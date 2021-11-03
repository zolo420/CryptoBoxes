<?php

namespace App\Http\Controllers\Api;

use App\Events\EmailInvitation as Invitation;
use App\Helpers\SettingsHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BitCoinApiService;
use Carbon\Carbon;
use EthereumRPC\EthereumRPC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Jobs\{SendMoneyBTC,SendMoneyETH};
use App\Http\Requests\Api\Profile\{
    SendInvitationRequest,
    BoxPaymentHistoryRequest,
    BuyBoxRequest,
    SwapRequest,
    WithdrawalRequest,
};
use Illuminate\Http\Response;
use App\Models\{EmailInvitation, Hints, TransactionHistory, Wallet, Box, BoxPaymentHistory, Bonus};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Helpers\{StringHelpers, WalletHelpers};
use Hash;

class ProfileController extends Controller
{
    public $user;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = \Auth::user('web');
    }

    /**
     * @param SendInvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInvitation(SendInvitationRequest $request): JsonResponse
    {
        event(new Invitation($this->user, $request->email));

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public function getInvitationHistory(): JsonResponse
    {
        $items = [];

        $emailInvitation = EmailInvitation::where('user_id', $this->user->id)->get();

        foreach ($emailInvitation as $row) {
            $items[] = [
                'email' => $row->email,
                'dateTime' => Carbon::parse($row->created_at)->format('d.m.Y H:i'),
                'status' => [
                    'disabled' => $row->is_registered,
                    'name' => $row->is_registered?  'Зарегистрировался' : 'Не зарегистрировался',
                    'color' => $row->is_registered?  '#4854AF' : '#FE4D17',
                ],
            ];
        }

        return response()->json(['items' => $items]);
    }

    /**
     * @return JsonResponse
     */
    public function getTransactionHistory(): JsonResponse
    {
        $items = [];

        foreach (TransactionHistory::where('user_id', $this->user->id)->with('wallet')->get() as $row) {
            $items[] = [
                'id' => $row->id,
                'receiver_address' => $row->receiver_address,
                'address_type' => $row->address_type,
                'value' => $row->amount,
                'transaction_type' => TransactionHistory::$transaction_type[$row->transaction_type],
                'date_time' => Carbon::parse($row->created_at)->format('d.m.Y H:i'),
                'direction' => [
                    'operator' => $row->transaction_type === TransactionHistory::TRANSACTION_REFILL? '+' : '',
                    'name' => TransactionHistory::$transaction_type[$row->transaction_type],
                    'color' => $row->transaction_type === TransactionHistory::TRANSACTION_REFILL? '#fe4d17' :
                        ($row->transaction_type === TransactionHistory::TRANSACTION_WITHDRAWAL? '#4854AF' : '#000000'),
                    'id' => $row->wallet_id,
                ],
                'currency' => $row->wallet->cryptocurrency
            ];
        }

        return response()->json(['items' => $items]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $rules = [
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'name' => 'required',
            'password' => 'min:6|nullable',
            'password_again' => 'min:6|same:password|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($request->id);
        $user->name = $request->input('name');


        if ($request->current_password && $request->password) {
            if (Hash::check($request->current_password, auth()->user()->password) == false)  return response()->json(['error' => 'Текущий пароль введен неверно!'], Response::HTTP_BAD_REQUEST);

            $user->password = Hash::make($request->password);
       }

        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * @param $cryptocurrency
     * @return JsonResponse
     */
    public function getBalance($cryptocurrency): JsonResponse
    {
        $wallet = Wallet::where('cryptocurrency', $cryptocurrency)->where('user_id', $this->user->id)->first();

        if (!$wallet) return response()->json(['error' => 'Not found'], Response::HTTP_NOT_FOUND);

        return response()->json(['item' => ['address' => $wallet->address, 'balance' => $wallet->balance]]);
    }

    /**
     * @param BoxPaymentHistoryRequest $request
     * @return JsonResponse
     */
    public function getBoxPaymentHistory(BoxPaymentHistoryRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $page = ($page - 1) * $limit;

        $boxPaymentHistory = BoxPaymentHistory::where('user_id', $this->user->id)->with('box');
        $count = $boxPaymentHistory->count();

        $items = [];

        foreach ($boxPaymentHistory->limit($limit)->offset($page)->get() as $row) {
            $items[] = [
                'id' => $row->id,
                'seed' => $row->seed,
                'caseId' => $row->box->id,
                'box' => [
                    'id' => $row->box->id,
                    'price' => $row->box->price,
                    'cryptocurrency' => $row->box->cryptocurrency,
                    'starting_bank' => $row->box->starting_bank,
                ],
                'currency' => [
                    'icon' => $row->box->cryptocurrency === 'eth'? 'ethereum' : 'bitcoin',
                    'color' => $row->box->cryptocurrency === 'eth'? '#4854AF' : '#FE4D17',
                ],
                'win' => $row->win,
                'dateTime' => Carbon::parse($row->created_at)->format('d.m.Y H:i'),
            ];
        }

        return response()->json(['items' => $items, 'count' => $count]);

    }

    /**
     * @param BuyBoxRequest $request
     * @return JsonResponse
     */
    public function buyBox(BuyBoxRequest $request): JsonResponse
    {
        $box = Box::where('id', $request->box_id)->where('is_archive', 0)->where('is_open', 0)->first();

        if (!$box) return response()->json(['error' => 'Кейс куплен или перемещен в архив'], Response::HTTP_NOT_FOUND);

        $balance = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $box->cryptocurrency)->sum('balance');
        $price = WalletHelpers::convert($box->cryptocurrency, $box->price, 'usd');

        if ($balance < $price) return response()->json(['error' => 'На вашем кошельке недостаточно средств'], Response::HTTP_BAD_REQUEST);

        try {
            $win = DB::transaction(function () use ($box, $price, $request) {

                if (StringHelpers::getSeedHash($box->seed) == StringHelpers::getSeedHash(explode(",", $request->seed)))
                    $win = 1;
                else
                    $win = 0;

                $boxPayment = BoxPaymentHistory::create([
                    'user_id' => $this->user->id,
                    'box_id' => $box->id,
                    'seed' => $request->seed,
                    'win' => $win,
                    'payment' => $price,
                    'payment_usd' => $box->price,
                    'cryptocurrency' => $box->cryptocurrency,
                ]);

                if ($win == 1) {
                    $box->is_open = 1;
                    $box->winner = $this->user->id;
                    $box->save();
                }

                $wallet = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $box->cryptocurrency)->first();
                $wallet->balance = $wallet->balance - $price;

                TransactionHistory::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $this->user->id,
                    'amount' => $price,
                    'receiver_address' => $wallet->address,
                    'address_type' => $box->cryptocurrency,
                    'transaction_type' => TransactionHistory::TRANSACTION_WRITEOFF,
                ]);

                $wallet->save();

                if ($box->cryptocurrency == 'btc') dispatch(new SendMoneyBTC($boxPayment));
                elseif ($box->cryptocurrency == 'eth') dispatch(new SendMoneyETH($boxPayment));

                return $win;

            });

            return response()->json(['result' => $win]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return JsonResponse
     */
    public function bonus(): JsonResponse
    {
        $bonus = Bonus::where('user_id', $this->user->id)->first();

        return response()->json(['bonus' => $bonus->count ?? 0]);
    }

    /**
     * @param SwapRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function swap(SwapRequest $request): JsonResponse
    {
        $wallet = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $request->from)->first();
        $price = WalletHelpers::convert($request->to, $request->amount, $request->from);

        if ($request->amount > $wallet->balance) return response()->json(['error' => 'На вашем кошельке недостаточно средств'], Response::HTTP_BAD_REQUEST);

        DB::beginTransaction();

        try {

            $wallet_btc = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', 'btc')->first();
            $wallet_eth = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', 'eth')->first();

            if ($request->to == 'btc') {

                $wallet_eth->balance = $wallet_eth->balance - $request->amount;
                $wallet_eth->save();

                $wallet_btc->balance = $wallet_btc->balance + $price;
                $wallet_btc->save();

                $eth = new EthereumRPC(env('ETH_HOST'), env('ETH_PORT'));
                $result = $eth->personal()->sendEthereum($request->from, SettingsHelpers::getSetting('ETH'), $price, env('ETH_PASSPHRASE'));

                if (!$result) throw new \Exception('Ошибка транзакции');

                TransactionHistory::create([
                    'wallet_id' => $wallet_btc->id,
                    'user_id' => $this->user->id,
                    'amount' => $price,
                    'receiver_address' => $wallet_btc->address,
                    'address_type' => 'btc',
                    'transaction_type' => TransactionHistory::TRANSACTION_REFILL,
                ]);

                TransactionHistory::create([
                    'wallet_id' => $wallet_eth->id,
                    'user_id' => $this->user->id,
                    'amount' => $request->amount,
                    'receiver_address' => $wallet_eth->address,
                    'transaction_hash' => $result,
                    'address_type' => 'eth',
                    'transaction_type' => TransactionHistory::TRANSACTION_WRITEOFF,
                ]);
            } else {

                $wallet_btc->balance = $wallet_btc->balance - $request->amount;
                $wallet_btc->save();

                $wallet_eth->balance = $wallet_eth->balance + $price;
                $wallet_eth->save();

                $bitCoin = new BitCoinApiService();
                $result = $bitCoin->sendToAddress($wallet_btc->address, $price, $this->user->id);

                if (!isset($result['txid'])) throw new \Exception('Ошибка транзакции');

                TransactionHistory::create([
                    'wallet_id' => $wallet_eth->id,
                    'user_id' => $this->user->id,
                    'amount' => $price,
                    'receiver_address' => $wallet_eth->address,
                    'address_type' => 'eth',
                    'transaction_type' => TransactionHistory::TRANSACTION_REFILL,
                ]);

                TransactionHistory::create([
                    'wallet_id' => $wallet_btc->id,
                    'user_id' => $this->user->id,
                    'amount' => $request->amount,
                    'receiver_address' => $wallet_btc->address,
                    'transaction_hash' => $result['txid'],
                    'address_type' => 'btc',
                    'transaction_type' => TransactionHistory::TRANSACTION_WRITEOFF,
                ]);
            }

            DB::commit();

            return response()->json(['result' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            log::info($e->getMessage());

            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param WithdrawalRequest $request
     * @return JsonResponse
     */
    public function withdrawal(WithdrawalRequest $request): JsonResponse
    {
        $wallet = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $request->from)->first();

        if ($request->amount > $wallet->balance) return response()->json(['error' => 'На вашем кошельке недостаточно средств'], Response::HTTP_BAD_REQUEST);

        DB::beginTransaction();

        try {

            if ($request->cryptocurrency == 'btc') {

                $bitCoin = new BitCoinApiService();
                $result = $bitCoin->sendToAddress($request->address, $request->amount, $this->user->id);

                if (!isset($result['txid'])) throw new \Exception('Ошибка транзакции');

                $wallet->balance  = $wallet->balance - $request->amount;
                $wallet->save();

                TransactionHistory::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $this->user->id,
                    'amount' => $request->amount,
                    'receiver_address' => $request->address,
                    'transaction_hash' => $result['txid'],
                    'address_type' => 'btc',
                    'transaction_type' => TransactionHistory::TRANSACTION_WITHDRAWAL,
                ]);

            } else {
                $eth = new EthereumRPC(env('ETH_HOST'), env('ETH_PORT'));
                $result = $eth->personal()->sendEthereum(SettingsHelpers::getSetting('ETH'), $request->address, $request->amount, SettingsHelpers::getSetting('ETH_PASSPHRASE'));

                if (!$result) throw new \Exception('Ошибка транзакции');

                $wallet->balance  = $wallet->balance - $request->amount;
                $wallet->save();

                TransactionHistory::create([
                    'wallet_id' => $wallet->id,
                    'user_id' => $this->user->id,
                    'amount' => $request->amount,
                    'receiver_address' => $request->address,
                    'transaction_hash' => $result,
                    'address_type' => 'eth',
                    'transaction_type' => TransactionHistory::TRANSACTION_WITHDRAWAL,
                ]);
            }

            DB::commit();

            return response()->json(['result' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            log::info($e->getMessage());

            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return JsonResponse
     */
    public function wallets(): JsonResponse
    {
        return response()->json(['items' => $this->user->wallets()->get()->map(function ($wallet) {
            return [
                'id' => $wallet->id,
                'address' => $wallet->address,
                'balance' => $wallet->balance,
                'cryptocurrency' => $wallet->cryptocurrency,
            ];
        })]);
    }


    public function buyHint(Box $box, Hints $hint)
    {
        if ( $box->hints()->get()->contains($hint) ) {
            $balance = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $box->cryptocurrency)->sum('balance');
            $price = WalletHelpers::convert($box->cryptocurrency, $hint->price, 'usd');
            if ($balance < $price) return response()->json(['error' => 'На вашем кошельке недостаточно средств'], Response::HTTP_BAD_REQUEST);

            $wallet = Wallet::where('user_id', $this->user->id)->where('cryptocurrency', $box->cryptocurrency)->first();
            $wallet->balance = $wallet->balance - $price;

            TransactionHistory::create([
                'wallet_id' => $wallet->id,
                'user_id' => $this->user->id,
                'amount' => $price,
                'receiver_address' => $wallet->address,
                'address_type' => $box->cryptocurrency,
                'transaction_type' => TransactionHistory::TRANSACTION_WRITEOFF,
            ]);

            $wallet->save();

            $boxPayment = BoxPaymentHistory::create([
                'user_id' => $this->user->id,
                'box_id' => $box->id,
                'seed' => [],
                'win' => 0,
                'payment' => $price,
                'payment_usd' => $hint->price,
                'cryptocurrency' => $box->cryptocurrency,
            ]);
            if ($box->cryptocurrency == 'btc') dispatch(new SendMoneyBTC($boxPayment));
            elseif ($box->cryptocurrency == 'eth') dispatch(new SendMoneyETH($boxPayment));
            return response()->json(['status' => 'ok']);

        }
        return response()->json(['error' => 'hint not found', 422]);
    }
}

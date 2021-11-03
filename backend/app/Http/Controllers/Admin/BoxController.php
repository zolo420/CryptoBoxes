<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\WalletHelpers;
use App\Models\{Box, BoxHint, BoxPaymentHistory, Hints};
use App\Services\BitCoinApiService;
use EthereumRPC\EthereumRPC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use URL;

class BoxController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.box.index')->with('title', 'Боксы');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $options = Hints::getOption();
        $currency = Box::$currency_name;
        $seed_options = [];

        foreach (Box::seeds() as $seed) {
            $seed_options[$seed] = $seed;
        }

        return view('cp.box.create_edit', compact('options', 'currency', 'seed_options'))->with('title', 'Добавление бокса');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seed' => 'required|array',
            'starting_bank' => 'required|numeric',
            'cryptocurrency' => 'required|in:eth,btc',
            'price' => 'required|integer',
            'hint_id' => 'required|array',
            'box_type' => 'required|integer',
        ]);

        $totalBalance = WalletHelpers::totalBalance($request->cryptocurrency);

        if ($totalBalance > $request->input('starting_bank')) {
            $validator->after(function ($validator) {
                $validator->errors()->add('starting_bank', 'На вашем балансе недостаточно средств!');
            });
        }

        $address = $this->getAddress($request->cryptocurrency);

        if (!$address) {
            $validator->after(function ($validator) {
                $validator->errors()->add('address', 'Ошибка создания кошелька!');
            });
        }

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request, $address) {

            $insertId = Box::create(array_merge($request->all(), ['address' => $address]))->id;

            if ($request->hint_id && $insertId) {
                foreach ($request->hint_id as $hint_id) {
                    if (is_numeric($hint_id)) {
                        BoxHint::create(['box_id' => $insertId, 'hint_id' => $hint_id]);
                    }
                }
            }

        });

        return redirect(URL::route('cp.box.index'))->with('success', 'Информация успешно добавлена');

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $row = Box::find($id);

        if (!$row) abort(404);

        $options = Hints::getOption();
        $currency = Box::$currency_name;
        $seed_options = [];

        foreach (Box::seeds() as $seed) {
            $seed_options[$seed] = $seed;
        }

        $boxHintId = [];

        foreach ($row->hints as $hint) {
            $boxHintId[] = $hint->id;
        }

        return view('cp.box.create_edit', compact('row', 'options', 'currency', 'boxHintId', 'seed_options'))->with('title', 'Редактирование бокса');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'seed' => 'required|array',
            'starting_bank' => 'required|numeric',
            'price' => 'required|integer',
            'hint_id' => 'required|array',
            'box_type' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $box = Box::find($request->id);

        if (!$box) abort(404);

        $box->seed = $request->input('seed');
        $box->starting_bank = $request->input('starting_bank');
        $box->price = $request->input('price');
        $box->box_type = $request->box_type;
        $box->save();

        BoxHint::where('box_id', $request->id)->delete();

        if ($request->hint_id) {
            foreach ($request->hint_id as $hint_id) {
                if (is_numeric($hint_id)) {
                    BoxHint::create(['box_id' => $request->id, 'hint_id' => $hint_id]);
                }
            }
        }

        return redirect(URL::route('cp.box.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        Box::where(['id' => $request->id])->delete();
        BoxHint::where('box_id', $request->id)->delete();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function archive(Request $request)
    {
        $temp = [];

        foreach ($request->activate as $id) {
            if (is_numeric($id)) {
                $temp[] = $id;
            }
        }

        Box::whereIN('id', $temp)->update(['is_archive' => $request->action]);

        return redirect(URL::route('cp.box.index'))->with('success', 'Данные обновлены');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function statistics($id)
    {
        $row = Box::find($id);

        if (!$row) abort(404);

        $total = BoxPaymentHistory::where('box_id', $id)->where('win', 0)->sum('payment_usd');
        $total_income = BoxPaymentHistory::where('box_id', $id)->where('win', 1)->sum('payment_usd');

        $income = $total_income * 100 / max(1, $total);
        $income = round($income, 2);
        $current_income = 100 - round($income, 2);

        return view('cp.box.statistics', compact('row', 'income', 'current_income'))->with('title', 'Статистика по боксу');
    }

    /**
     * @param $cryptocurrency
     * @return bool|string
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\GethException
     * @throws \HttpClient\Exception\HttpClientException
     */
    private function getAddress($cryptocurrency)
    {
        if ($cryptocurrency == 'btc') {
            $address = WalletHelpers::bitcoinAddress();

            $bitCoin = new BitCoinApiService();
            $bitCoin->createWallet($address);
        } else {
            $eth = new EthereumRPC(env('ETH_HOST'), env('ETH_PORT'));
            $address = $eth->personal()->newAccount(env('ETH_PASSPHRASE'));
        }

        return $address;
    }
}

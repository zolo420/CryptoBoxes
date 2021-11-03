<?php

namespace App\Jobs;

use App\Models\{Wallet,User,BoxPaymentHistory,Bonus,EmailInvitation,TransactionHistory};
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Services\BitCoinApiService;
use App\Helpers\SettingsHelpers;


class SendMoneyBTC implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public BoxPaymentHistory $boxPayment;

    public function __construct(BoxPaymentHistory $boxPayment)
    {
        $this->boxPayment = $boxPayment;
    }

    public function handle()
    {
        try {

            $bitCoin = new BitCoinApiService();
            $result = $bitCoin->sendToAddress(SettingsHelpers::getSetting('BTC'), $this->boxPayment->amount, $this->boxPayment->user_id);

            if (isset($result['txid'])) {

                $emailInvitation = EmailInvitation::where('email', 'like', $this->boxPayment->user->email);

                if ($emailInvitation->count() > 0) {
                    $row = $emailInvitation->first();
                    $bonus = Bonus::where('user_id', $row->user_id);

                    if ($bonus->count() == 0) {
                        Bonus::create([
                            'user_id' => $row->user_id,
                            'count' => 1,
                        ]);
                    } else {
                        $userBonus = $bonus->first();
                        $userBonus->count = $userBonus->count + 1;
                        $userBonus->save();
                    }
                }

                TransactionHistory::create([
                    'wallet_id' => $this->boxPayment->user->wallet('btc')->address,
                    'user_id' => $this->boxPayment->user->id,
                    'amount' => $this->boxPayment->amount,
                    'receiver_address' => SettingsHelpers::getSetting('BTC'),
                    'address_type' => 'btc',
                    'transaction_hash' => $result['txid'],
                    'transaction_type' => TransactionHistory::TRANSACTION_WRITEOFF,
                ]);
            }

        } catch (\Exception $e) {
            log::info($e->getMessage());
            return false;
        }
    }
}

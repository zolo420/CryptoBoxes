<?php

namespace App\Jobs;

use App\Models\{Wallet, User};
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Services\BitCoinApiService;
use App\Helpers\WalletHelpers;

class CreateBTCWallet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        try {

            $address = WalletHelpers::bitcoinAddress();
            if ($address) {
                Wallet::create([
                    'address' => $address,
                    'cryptocurrency' => 'btc',
                    'user_id' => $this->user->id
                ]);

                $bitCoin = new BitCoinApiService();
                $bitCoin->createWallet($address);
            }
        } catch (\Exception $e) {

            log::info('BTC wallet error ' . $e->getMessage());
            return false;
        }
    }
}

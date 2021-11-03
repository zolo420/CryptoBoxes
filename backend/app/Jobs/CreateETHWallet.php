<?php

namespace App\Jobs;

use App\Models\{Wallet, User};
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use EthereumRPC\EthereumRPC;


class CreateETHWallet implements ShouldQueue
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

            $eth = new EthereumRPC(env('ETH_HOST'),env('ETH_PORT'));
            $address = $eth->personal()->newAccount(env('ETH_PASSPHRASE'));

            if ($address) {
                Wallet::create([
                    'address' => $address,
                    'cryptocurrency' => 'eth',
                    'user_id' => $this->user->id
                ]);
            }

        } catch (\Exception $e) {
            log::info('ETC wallet error ' . $e->getMessage());
            return false;
        }
    }
}

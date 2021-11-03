<?php

namespace App\Console\Commands;

use App\Models\Wallet;
use EthereumRPC\EthereumRPC;
use Illuminate\Console\Command;

class ETHBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:eth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check ETH balance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        @set_time_limit(0);

        $fh = fopen(__FILE__, 'r');

        if (!flock($fh, LOCK_EX | LOCK_NB)) {
            exit('Script is already running');
        }

        $this->line('start checking balance');

        $eth = new EthereumRPC(env('ETH_HOST'),env('ETH_PORT'));

        foreach (Wallet::where('cryptocurrency', 'btc')->get() as $row) {
            $result = $eth->eth()->getBalance($row->address);

            if ($result > 0) {
                $wallet = Wallet::find($row->id);
                $wallet->balance = $result;
                $wallet->save();
            }
        }

        $this->line("end checking balance");

    }
}

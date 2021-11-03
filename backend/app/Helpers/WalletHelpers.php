<?php

namespace App\Helpers;

use App\Services\BitCoinApiService;
use EthereumRPC\EthereumRPC;
use Illuminate\Support\Facades\Redis;

class WalletHelpers
{
    public static function bitcoinAddress()
    {
        $api = new BitCoinApiService();
        $address = $api->getNewAddress();

        return $address;
    }

    /**
     * @param $currentcurrency
     * @param $rate
     * @param $currency
     * @return false|float|string
     * @throws \Exception
     */
    public static function convert($currentcurrency, $rate, $currency)
    {
        $rate_array = \Cache::get($currentcurrency);

        if ($rate_array == null) {
            $rate_array = \App\Helpers\StringHelpers::getCurrencyRate($currentcurrency);

            if (!isset($rate_array)) throw new \Exception('Сервис недоступен');

            \Cache::set($currentcurrency, json_encode($rate_array), 'EX', 15);
        }

        if (!is_array($rate_array)) $rate_array = json_decode($rate_array, true);

        if (!isset($rate_array[strtoupper($currency)])) return '';

        return round($rate / $rate_array[strtoupper($currency)], 8);
    }

    /**
     * @param $currency
     * @return false|float
     * @throws \Exception
     */
    public static function RateCurrency($currency)
    {
        $rate_array = \Cache::get($currency);

        if ($rate_array == null) {
            $rate_array = \App\Helpers\StringHelpers::getCurrencyRate($currency);

            if (!isset($rate_array)) throw new \Exception('Сервис недоступен');

            \Cache::set($currency,json_encode($rate_array), 'EX', 15);
        }

        if (!is_array($rate_array)) $rate_array = json_decode($rate_array, true);

        return round($rate_array[strtoupper(SettingsHelpers::getSetting('currency'))], 2);

    }

    /**
     * @param $cryptocurrency
     * @return mixed|string|null
     * @throws \EthereumRPC\Exception\ConnectionException
     * @throws \EthereumRPC\Exception\GethException
     * @throws \HttpClient\Exception\HttpClientException
     */
    public static function totalBalance($cryptocurrency)
    {
        $balance = null;

        if ($cryptocurrency == 'btc') {

            $balance = \Cache::get('btc-total-balance');

            if ($balance == null) {
                $bitCoin = new BitCoinApiService();
                $balance = $bitCoin->getBalance();

                \Cache::set('btc-total-balance', $balance, 'EX', 15);
            }
        } elseif ($cryptocurrency == 'eth') {
            $balance = \Cache::get('eth-total-balance');

            if ($balance == null) {
                $eth = new EthereumRPC(env('ETH_HOST'), env('ETH_PORT'));
                try {
                    $balance = $eth->eth()->getBalance(SettingsHelpers::getSetting('ETH'));
                } catch (\Exception $exception) {
                    $balance = 0;
                }

                \Cache::set('eth-total-balance', $balance, 'EX', 15);
            }
        }

        return $balance;
    }
}

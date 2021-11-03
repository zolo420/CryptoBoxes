<?php

namespace App\Services;

use App\Helpers\StringHelpers;

class BitCoinApiService
{
    protected $api;

    /**
     * BitCoinApiService constructor.
     * @param $user
     * @param $pass
     * @param $host
     * @param $port
     */
    public function __construct()
    {
        $this->api = new Bitcoin(env('BITCOIND_USER'), env('BITCOIND_PASSWORD'), env('BITCOIND_HOST'), env('BITCOIND_PORT'));
    }

    /**
     * @param $address
     * @return bool
     */
    public function createWallet($address)
    {
        $response = $this->api->createwallet($address);

        return $response ? $response : false;
    }

    /**
     * @param $address
     * @return mixed
     */
    public function verifyAddress($address)
    {
        $response = $this->api->validateaddress($address);

        return $response['isvalid'];
    }

    /**
     * @param $address
     * @param $amount
     * @param $userId
     * @return bool
     */
    public function sendToAddress($address, $amount, $userId)
    {
        $fromQueue = 'From Auth';

        if (empty($adminId)) {
            $fromQueue = 'From Queue';
        }

        if (empty($givenAuthId)) {
            return false;
        }

        $comment = "$fromQueue , User ID: " . $userId;

        return $response = $this->api->sendtoaddress($address, $amount, $comment);
    }

    /**
     * @param $toAddress
     * @param $amount
     * @param string $fromAccount
     * @return mixed
     */
    public function sendFrom($toAddress, $amount, $fromAccount = '')
    {
        return $response = $this->api->sendfrom($fromAccount, $toAddress, StringHelpers::customNumberFormat($amount));
    }

    /**
     * @param string $account
     * @return bool
     */
    public function getNewAddress($account = '')
    {
        $response = $this->api->getnewaddress($account);

        return $response ? $response : false;
    }

    /**
     * @return bool
     */
    public function getAllAccounts()
    {
        $response = $this->api->listaccounts();

        return $response ? $response : false;
    }

    /**
     * @param $address
     * @param int $minConfirm
     * @return bool
     */
    public function getReceivedByAddress($address, $minConfirm = 6)
    {
        $response = $this->api->getreceivedbyaddress($address, $minConfirm);

        return $response ? $response : false;
    }

    /**
     * @param int $minConfirm
     * @return bool
     */
    public function listReceivedByAddress($minConfirm = 1)
    {
        $response = $this->api->listreceivedbyaddress($minConfirm);

        return $response ? $response : false;
    }

    /**
     * @param $passPhrase
     * @param $timeOut
     * @return bool
     */
    public function walletPassPhrase($passPhrase, $timeOut)
    {
        $response = $this->api->walletpassphrase($passPhrase, $timeOut);

        return $response ? $response : false;
    }

    /**
     * @param $oldPassPhrase
     * @param $newPassPhrase
     * @return bool
     */
    public function walletPassPhraseChange($oldPassPhrase, $newPassPhrase)
    {
        $response = $this->api->walletpassphrase($oldPassPhrase, $newPassPhrase);

        return $response ? $response : false;
    }

    /**
     * @param $transcationId
     * @return mixed
     */
    public function getTranscation($transcationId)
    {
        $response = $this->api->gettransaction($transcationId);

        return $response;
    }

    /**
     * @param string $account
     * @return mixed
     */
    public function getBalance($account = '')
    {
        $response = $this->api->getbalance($account);

        return $response;
    }

    /**
     * @param int $last
     * @return mixed
     */
    public function getLastTransactions($last = 10)
    {
        return $this->api->listtransactions('', $last);
    }
}

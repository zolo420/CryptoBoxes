<?php

namespace App\Helpers;

class StringHelpers
{
    /**
     * @param $data
     * @return array
     */
    public static function ObjectToArray($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::ObjectToArray($value);
            }
            return $result;
        }
        return $data;
    }

    /**
     * @param int $max
     * @return null|string
     */
    public static function randomText($max = 6)
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $size = strlen($chars) - 1;
        $text = null;

        while ($max--)
            $text .= $chars[rand(0, $size)];

        return $text;
    }

    /**
     * @return string
     */
    public static function token()
    {
        return md5(uniqid(rand(), TRUE));
    }

    /**
     * @param $str
     * @param int $chars
     * @return string
     */
    public static function shortText($str, $chars = 500)
    {
        $pos = strpos(substr($str, $chars), " ");
        $srttmpend = strlen($str) > $chars ? '...' : '';

        return substr($str, 0, $chars + $pos) . (isset($srttmpend) ? $srttmpend : '');
    }

    /**
     * @param $ip
     * @return mixed
     */
    public static function geoLocation($ip)
    {
        $ch = curl_init('http://ip-api.com/json/' . $ip . '?lang=ru');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }

    /**
     * @param $symbol
     * @return mixed
     */
    public static function getCurrencyRate($currency)
    {
        $ch = curl_init('https://api.coinbase.com/v2/exchange-rates?currency=' . $currency);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $res = curl_exec($ch);
        curl_close($ch);

        $arrayData = json_decode($res, true);

        return $arrayData['data']['rates'];
    }

    /**
     * @param array $seed
     * @return string
     */
    public static function getSeedHash($seed = array())
    {
        return md5(implode(',', $seed));
    }

    /**
     * @param $value
     * @return string
     */
    public static function customNumberFormat($value)
    {
        if (is_integer($value)) {
            return number_format($value, 8, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 10, '.', ''));
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

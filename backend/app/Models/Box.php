<?php

namespace App\Models;

use App\Helpers\SettingsHelpers;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    public const CURRENCY_ETH = 'eth';

    public const CURRENCY_BTC = 'btc';

    public const HARD_BOX = 0;

    public const EASY_BOX = 1;

    public const QUEST_BOX = 2;

    protected $table = 'box';

    protected $primaryKey = 'id';

    protected $fillable = [
        'seed',
        'starting_bank',
        'price',
        'cryptocurrency',
        'address',
        'box_type',
    ];

    public static $currency_name = [
        self::CURRENCY_ETH => 'ethereum',
        self::CURRENCY_BTC => 'bitcoin',
    ];

    public static $box_name = [
        self::HARD_BOX  => 'Hard-box',
        self::EASY_BOX  => 'Easy-box',
        self::QUEST_BOX => 'Quest-box',
    ];

    /**
     * @param $value
     */
    public function setSeedAttribute($value)
    {
        $this->attributes['seed'] = $value ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getSeedAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function hints()
    {
        return $this->hasManyThrough(Hints::class, BoxHint::class, 'box_id', 'id', 'id', 'hint_id');
    }

    public static function seeds(): array
    {
        $seeds = explode(',', SettingsHelpers::getSetting('seed_list'));
        if ( $seeds ) {
            return $seeds;
        }
        return [
            'world',
            'hello',
            'last',
            'down',
            'sun',
            'phonet',
            'ready',
            'car',
            'watch',
            'together',
            'street',
            'cat',
        ];
    }

    public function paymentHistory()
    {
        return $this->hasMany(BoxPaymentHistory::class);
    }

    public function getParticipantsNumber()
    {
        return $this->paymentHistory()->distinct('user_id')->count();
    }


    public function getFrontData(): array
    {
        $seed = $this->seed;
        shuffle($seed);
        return [
            'id'           => $this->id,
            'price'        => $this->price,
            'address'      => $this->address,
            'seed'         => $seed,
            'bank'         => $this->starting_bank,
            'participants' => $this->getParticipantsNumber(),
            'hints'        => $this->hints()->get(),
        ];
    }
}


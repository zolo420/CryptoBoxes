<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxPaymentHistory extends Model
{

    protected $table = 'box_payment_history';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'box_id',
        'seed',
        'payment',
        'cryptocurrency',
        'win',
        'payment_usd',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function box()
    {
        return $this->hasOne(Box::class,'id','box_id');
    }

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

}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $fillable = [
        'email',
        'password',
        'email_verified_at',
        'password',
        'name',
        'social_id',
        'social_type'

    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * @param $cryptocurrency
     * @return float
     */
    public function totalBalance($cryptocurrency)
    {
        $wallet = Wallet::where('user_id',$this->id)->where('cryptocurrency',$cryptocurrency)->first();

        if (!$wallet) return 0.00000000;

        return $wallet->balance;
    }

    /**
     * @param $cryptocurrency
     * @return mixed
     */
    public function wallet($cryptocurrency)
    {
        return Wallet::where('user_id',$this->id)->where('cryptocurrency',$cryptocurrency)->first();
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastLogin()
    {
        return $this->hasOne(Logs::class,'user_id', 'id')->latest();
    }

    public function boxHistory()
    {
        return $this->hasMany(BoxPaymentHistory::class);
    }

    public function boughtHints()
    {
        return $this->belongsToMany(Hints::class, 'user_hints','user_id', 'hint_id')->where('user_id', $this->id);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    public const ACTION_LOGIN = 0;

    public const ACTION_REGISTRATION = 1;

    public const ACTION_PASSWORD_RESET = 2;

    protected $table = 'logs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ip',
        'location',
        'user_agent',
        'user_id',
        'action',
    ];

    public static $action_name = [
        self::ACTION_LOGIN => 'авторизация',
        self::ACTION_REGISTRATION => 'регистрация',
        self::ACTION_PASSWORD_RESET => 'сброс пароля',
    ];

    /**
     * @param $value
     */
    public function setLocationAttribute($value)
    {
        $this->attributes['location'] = $value ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getLocationAttribute($value)
    {
        return json_decode($value);
    }
}

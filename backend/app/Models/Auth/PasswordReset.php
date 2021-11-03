<?php

namespace App\Models\Auth;

use Eloquent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Сброс пароля.
 *
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 * @method static Builder|PasswordReset newModelQuery()
 * @method static Builder|PasswordReset newQuery()
 * @method static Builder|PasswordReset query()
 * @method static Builder|PasswordReset whereCreatedAt($value)
 * @method static Builder|PasswordReset whereEmail($value)
 * @method static Builder|PasswordReset whereToken($value)
 * @mixin Eloquent
 */
class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';

    public const UPDATED_AT = null;

    /**
     * @var string[]
     */
    protected $fillable = ['email', 'token'];

    /**
     * @var null
     */
    protected $primaryKey = 'token';

    /**
     * @var bool
     */
    public $incrementing = false;

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
}

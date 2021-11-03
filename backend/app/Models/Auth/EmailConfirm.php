<?php

namespace App\Models\Auth;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EmailConfirm extends Model
{
    use HasFactory;

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
}

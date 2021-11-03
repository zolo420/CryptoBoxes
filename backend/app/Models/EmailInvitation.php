<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class EmailInvitation extends Model
{
    use HasFactory;

    protected $table = 'email_invitation';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'email', 'token'];

    /**
     * @var null
     */
    protected $primaryKey = 'token';

    /**
     * @var bool
     */
    public $incrementing = false;

}

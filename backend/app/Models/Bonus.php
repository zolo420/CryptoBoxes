<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{

    protected $table = 'bonus';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'count',
    ];

}

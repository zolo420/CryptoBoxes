<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTotal extends Model
{
    protected $table = 'wallet_total';

    protected $primaryKey = 'id';

    protected $fillable = [
        'address',
        'balance',
        'cryptocurrency',
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{

    public const TRANSACTION_REFILL = 0;
    public const TRANSACTION_WITHDRAWAL = 1;
    public const TRANSACTION_WRITEOFF = 2;

    protected $table = 'transaction_history';

    protected $primaryKey = 'id';

    protected $fillable = [
        'wallet_id',
        'user_id',
        'amount',
        'receiver_address',
        'transaction_type',
        'transaction_hash',
        'address_type',
    ];

    public static $transaction_type = [
        self::TRANSACTION_REFILL => 'Пополнение',
        self::TRANSACTION_WITHDRAWAL => 'Вывод',
        self::TRANSACTION_WRITEOFF => 'Списание',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}

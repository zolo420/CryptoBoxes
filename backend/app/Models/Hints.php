<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hints extends Model
{
    public const DIRECTORY = '/uploads/icon/';

    protected $table = 'hints';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'price',
        'description',
        'icon',
    ];

    /**
     * @return mixed
     */
    public static function getOption()
    {
        return Hints::orderBy('name')->get()->pluck('name', 'id');
    }

}

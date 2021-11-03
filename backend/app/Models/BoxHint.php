<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxHint extends Model
{

    protected $table = 'box_hint';

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'hint_id',
        'box_id'
    ];

}

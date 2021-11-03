<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'settings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'value'
    ];

    /**
     * @param $value
     */
    public function setNameAttribute($value) {
        $this->attributes['name'] = str_replace(' ', '_', $value);
    }

}

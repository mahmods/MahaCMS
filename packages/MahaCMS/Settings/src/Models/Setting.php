<?php

namespace MahaCMS\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'setting_name', 'setting_value'
    ];
}

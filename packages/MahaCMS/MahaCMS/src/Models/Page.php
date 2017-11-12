<?php

namespace MahaCMS\MahaCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
    protected $fillable = ['slug', 'view'];

    public function fields() {
        return $this->hasMany('MahaCMS\MahaCMS\Models\Field', 'page_id');
    }

}

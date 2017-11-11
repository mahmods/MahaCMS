<?php

namespace MahaCMS\MahaCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public $timestamps = false;
    protected $fillable = ['page_id', 'name', 'value', 'category'];

    public function page() {
        return $this->belongsTo('MahaCMS\MahaCMS\Models\Page');
    }
}

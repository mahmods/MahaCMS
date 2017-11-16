<?php

namespace MahaCMS\MahaCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
    protected $fillable = ['slug', 'template_id'];

    public function fields() {
        return $this->hasMany('MahaCMS\MahaCMS\Models\Field', 'page_id');
    }

    public function template() {
        return $this->belongsTo('MahaCMS\MahaCMS\Models\Template');
    }

    public function delete()
    {
        if($this->slug == 'home') {
            return false;
        } else {
            return parent::delete();
        }
    }

}

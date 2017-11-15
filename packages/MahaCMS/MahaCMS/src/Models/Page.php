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

    public function template() {
        return $this->belongsTo('MahaCMS\MahaCMS\Models\Template');
    }

    public function delete()
    {
        if($this->slug = 'home') {
            return 'You can`t delete the home page.';
        } else {
            return parent::delete();
        }
    }

}

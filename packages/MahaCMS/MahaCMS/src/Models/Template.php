<?php

namespace MahaCMS\MahaCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function fields_type() {
        return explode('|', $this->fileds_type);
    }
}

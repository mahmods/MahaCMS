<?php

namespace MahaCMS\Profile\Models;

use Illuminate\Database\Eloquent\Model;
use MahaCMS\Users\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'nickname', 'first_name', 'last_name', 'description'
    ];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(PostUser::class);
    }
}

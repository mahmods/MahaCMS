<?php

namespace MahaCMS\Roles\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
	protected $fillable = ['role_id', 'user_id'];
}

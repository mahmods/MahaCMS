<?php

namespace MahaCMS\Permissions\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = ['perm', 'name'];
}

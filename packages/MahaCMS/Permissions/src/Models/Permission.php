<?php

namespace MahaCMS\Permissions\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = ['name', 'perm'];

	public static function form($model = null)
    {
        return json_encode(array(
            'form' => [
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Name',
                    'model' => 'name',
                    'value' => $model ? $model->name : ''
                ),
                array(
                    'type' => 'input',
                    'innerType' => 'text',
                    'label' => 'Slug',
                    'model' => 'perm',
                    'value' => $model ? $model->perm : ''
                )
            ]
        ));
    }
}

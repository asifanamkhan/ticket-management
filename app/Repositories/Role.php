<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role as Model;
use App\Repositories\BaseRepository;

class Role extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:roles',
        ],
        'update' => [
            'name' => 'required|unique:roles',
        ]
    ];


}

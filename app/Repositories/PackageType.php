<?php

namespace App\Repositories;

use App\Models\PackageType as Model;
use App\Repositories\BaseRepository;

class PackageType extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:package_types',
        ],
        'update' => []
    ];

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => "required|unique:package_types,name,{$id}",
        ];
        return parent::update($id, $data);
    }
}
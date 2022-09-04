<?php

namespace App\Repositories;

use App\Models\Day as Model;
use App\Models\Package;
use App\Repositories\BaseRepository;

class Day extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:days,name,NULL,id,deleted_at,NULL',
            'code' => 'required|unique:days,code,NULL,id,deleted_at,NULL',
        ],
        'update' => []
    ];

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => "required|unique:days,name,{$id},id,deleted_at,NULL",
            'code' => "required|unique:days,code,{$id},id,deleted_at,NULL",
        ];
        return parent::update($id, $data);
    }

    public static function delete($id): array
    {
        if (Package::whereDayId($id)->exists()) {
            return [
                'status' => 'error',
                'data' => "The Day already used in packages."
            ];
        }

        return parent::delete($id);
    }
}

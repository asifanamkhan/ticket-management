<?php

namespace App\Repositories\Country;

use App\Models\Country as Model;
use App\Repositories\BaseRepository;

class Country extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:countries',
            'code' => 'required|unique:countries'
        ],
        'update' => []
    ];

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'name' => 'required|unique:countries,name,' . $id,
            'code' => 'required|unique:countries,code,' . $id
        ];
        return parent::update($id, $data);
    }
}
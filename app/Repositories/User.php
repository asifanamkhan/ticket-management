<?php

namespace App\Repositories;

use App\Models\User as Model;
use Illuminate\Validation\Rule;
use App\Repositories\BaseRepository;

class User extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:8|confirmed',
            'mobile' => 'numeric|min:10',

        ],
        'update' => []
    ];

    public static function save($data): array
    {
        static::$rules['save']['email'] = [
            'required',
            'email',
            Rule::unique('users')->where(function($query) use($data){
                return $query->where('email', $data['email'])
                    ->whereNull('provider')
                    ->whereNull('provider_id');
            })
        ];
        return parent::save($data);
    }

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:users,email,{$id},id,provider,NULL,provider_id,NULL",
            'mobile' => "numeric|min:10",

        ];
        return parent::update($id, $data);
    }
}

<?php

namespace App\Repositories;

use App\Models\Order\Order;
use App\Models\User as Model;
use Illuminate\Validation\Rule;
use App\Repositories\BaseRepository;
use DB;

class Visitor extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [],
        'update' => []
    ];

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

    public static function delete($id): array
    {
        if (Order::whereUserId($id)->exists()) {
            return [
                'status' => 'error',
                'data' => "The visitor had an order. please delete the order first to delete the visitor "
            ];
        }

        return parent::delete($id);
    }

    public static function totalCount(){
        $count = Model::count();

        if(isset($count)){
            return [
                'status' => 'success',
                'data' => $count
            ];
        }

    }

}

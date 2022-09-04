<?php

namespace App\Repositories\Order;

use App\Models\Order\OrderCustomer as Model;
use App\Repositories\BaseRepository;

class OrderCustomer extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'order_id' => 'required',
            'user_id' => 'required',
        ],
        'update' => [
            'order_id' => 'required',
            'user_id' => 'required',
        ]
    ];

    public static function customer($order_id, $user_id){
        try{
            $customer = Model::where('order_id',$order_id)
                              ->where('user_id',$user_id)
                              ->first();

            if($customer){
                return [
                    'status' => 'success',
                    'data' => $customer
                ];
            }

        }catch (\Exception $exception){
            return [
                'status' => 'error',
                'data' => $exception->getMessage()
            ];
        }
    }

}

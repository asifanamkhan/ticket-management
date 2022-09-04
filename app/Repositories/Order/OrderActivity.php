<?php

namespace App\Repositories\Order;

use App\Models\Order\OrderActivity as Model;
use App\Repositories\BaseRepository;

class OrderActivity extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'order_detail_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ],
        'update' => [
            'qty' => 'required',
        ]
    ];


    public static function searchAddon($orderDetailId,$activity_id){

        try{
            $addOn=  Model::where('order_detail_id',$orderDetailId)
                            ->where('activity_id',$activity_id)
                            ->first();
            if($addOn){
                return [
                    'status' => 'success',
                    'data' => $addOn
                ];
            }


        }
        catch (\Exception $exception){
            return response()->json([
                'status' => 'error',
                'data' => $exception->getMessage()
            ]);
        }

    }

}

<?php

namespace App\Repositories\Order;

use App\Models\Order\ActivityPayment as Model;
use App\Repositories\BaseRepository;
use DB;

class ActivityPayment extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'order_activity_id' => 'required',
            'cart_id' => 'required',
            'status' => 'required',
        ],
        'update' => [
            'order_activity_id' => 'required',
            'cart_id' => 'required',
            'status' => 'required',
        ]
    ];

    public static function cartNoGenerate (){

        $count = DB::table('activity_payments')->count();

        $cart_no = 'TK' . (int)(6000 + ($count + 1 ));

        return [
            'status' => 'success',
            'data' => $cart_no
        ];

    }

}

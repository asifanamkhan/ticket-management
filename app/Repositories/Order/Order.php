<?php

namespace App\Repositories\Order;

use App\Models\Order\Order as Model;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;

class Order extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'user_id' => 'required',
            'cart_total' => 'required',
            'cart_id' => 'required|unique:orders',
        ],
        'update' => []
    ];

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'cart_id' => "required|unique:orders,cart_id,{$id}",
        ];
        return parent::update($id, $data);
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

    public static function cartNoGenerate (){

        $count = DB::table('orders')->count();

        $cart_no = 'TK' . (int)(6000 + ($count + 1 ));

        return [
            'status' => 'success',
            'data' => $cart_no
        ];

    }

    public static function latestOrder($interval){

        $count = Model::where('created_at','>=', Carbon::now()->subDays($interval)->toDateString())
                 ->count();

        if(isset($count)){
            return [
                'status' => 'success',
                'data' => $count
            ];
        }
    }



    public static function statusFilter($data): array {
        static::$exactSearchFields = ['status'];
        return parent::search($data);
    }
}

<?php

namespace App\Repositories\Order;

use App\Models\Order\OrderDetails as Model;
use App\Repositories\BaseRepository;

class OrderDetails extends BaseRepository
{
    protected static $model = Model::class;

    public static function save($data): array
    {
        static::$rules['save'] = [
            'order_id' => 'required',
            'type_name' => 'required',
            'type_id' => 'required',
            'day_code' => 'required',
            'day_name' => 'required',
            'name' => 'required',
            'package_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ];
        
        return parent::save($data);
    }

    public static function update($id, $data): array
    {
        static::$rules['update'] = [
            'order_id' => 'required',
            'type_name' => 'required',
            'type_id' => 'required',
            'day_code' => 'required',
            'day_name' => 'required',
            'name' => 'required',
            'package_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ];
        return parent::update($id, $data);
    }
}

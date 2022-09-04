<?php

namespace App\Repositories\Order;

use App\Models\Order\OrderName as Model;
use App\Repositories\BaseRepository;

class OrderName extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [
            'order_detail_id' => 'required',
            'name' => 'required',
        ],
        'update' => [
            'order_detail_id' => 'required',
            'name' => 'required',
        ]
    ];

}
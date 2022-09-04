<?php

namespace App\Repositories;

use App\Models\Log as Model;
use App\Repositories\BaseRepository;

class Log extends BaseRepository
{
    protected static $model = Model::class;

    protected static $rules = [
        'save' => [],
        'update' => []
    ];

}

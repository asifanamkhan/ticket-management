<?php

namespace App\Models\Order;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderActivity extends Model
{
    use HasFactory, SoftDeletes;


    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }

    protected $casts = [
        'images' => 'array'
    ];
}

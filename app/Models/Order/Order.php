<?php

namespace App\Models\Order;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;


    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetails::class,'order_id');
    }

    public function orderActivities(): HasMany
    {
        return $this->hasMany(OrderActivity::class,'order_detail_id');
    }

    public function orderNames(): HasMany
    {
        return $this->hasMany(OrderName::class,'order_detail_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}

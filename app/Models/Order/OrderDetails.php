<?php

namespace App\Models\Order;

use App\Models\Order\OrderName;
use App\Models\Order\OrderActivity;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;


    public function activities(): HasMany
    {
        return $this->hasMany(OrderActivity::class, 'order_detail_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class,'package_id','id');
    }

    public function names(): HasMany
    {
        return $this->hasMany(OrderName::class, 'order_detail_id');
    }
}

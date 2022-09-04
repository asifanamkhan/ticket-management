<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Log extends Model
{
    use HasFactory;

    protected $casts = [
        'to' => 'array',
        'from' => 'array'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }

}

<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Day extends Model
{
    use HasFactory, SoftDeletes;

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

}

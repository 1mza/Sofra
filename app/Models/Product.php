<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function seller() :BelongsTo{
        return $this->belongsTo(Seller::class);
    }

    public function orders() :BelongsToMany{
        return $this->belongsToMany(Order::class);
    }
}

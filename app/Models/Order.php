<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products() :BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot('price','special_note','quantity');
    }

    public function client() :BelongsTo{
        return $this->belongsTo(Client::class);
    }

    public function seller() :BelongsTo{
        return $this->belongsTo(Seller::class);
    }
}

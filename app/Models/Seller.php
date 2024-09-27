<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Seller extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories() :BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function token() : HasOne{
        return $this->hasOne(Token::class);
    }

    public function products() :HasMany{
        return $this->hasMany(Product::class);
    }

    public function offers() :HasMany{
        return $this->hasMany(Offer::class);
    }

    public function commissions() :HasMany{
        return $this->hasMany(Commission::class);
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

}

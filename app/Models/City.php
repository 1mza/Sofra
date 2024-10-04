<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighbourhood::class);
    }

    public function sellers(): HasMany
    {
        return $this->hasMany(Seller::class);
    }
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}

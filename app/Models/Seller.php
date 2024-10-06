<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Seller extends Model
{
    use HasFactory, Notifiable;

    protected $hidden = ['password', 'api_token', 'pin_code', 'pin_code_expires_at'];

    protected $guarded = [];

    protected static function booted(): void
    {
        static::saving(function($seller){
            $seller->app_commissions = $seller->restaurant_sales * 0.1;
        });
    }

    public function categories() :BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function token() : HasOne{
        return $this->hasOne(Token::class);
    }

    public function products() :HasMany{
        return $this->hasMany(Product::class);
    }

    public function orders() : hasMany{
        return $this->hasMany(Order::class);
    }

    public function offers() :HasMany{
        return $this->hasMany(Offer::class);
    }

    public function commissions() :HasMany{
        return $this->hasMany(Commission::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function city() : BelongsTo{
        return $this->belongsTo(City::class);
    }
    public function neighbourhood() : BelongsTo{
        return $this->belongsTo(Neighbourhood::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }


}

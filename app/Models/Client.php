<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = ['password', 'api_token', 'pin_code', 'pin_code_expires_at'];


    public function token() : HasOne{
        return $this->hasOne(Token::class);
    }

    public function orders() : hasMany{
        return $this->hasMany(Order::class);
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

}

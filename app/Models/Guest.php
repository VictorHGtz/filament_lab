<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Guest extends Model
{
    //
    protected $fillable = [
        'guest_code',
        'guest_name',
        'max_guests',
        'confirmed_guests',
        'confirmed_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            if (blank($guest->guest_code)) {
                $guest->guest_code = static::generateGuestCode();
            }
        });
    }

    protected static function generateGuestCode(): string
    {
        do {
            $code = 'NV-' . strtoupper(Str::random(6));
        } while (static::where('guest_code', $code)->exists());


        return $code;
    }
}

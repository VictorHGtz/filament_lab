<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'activo',
    ];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class);
    }
}

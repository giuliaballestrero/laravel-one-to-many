<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    
    // inserisco i fillable della nuova tabella Types
    protected $fillable = ['name', 'color' ];

    //definisco la relaizone one to many (tanti projects dipendono da un type)
    public function types(){
        return $this->hasMany(Type::class);
    }
}

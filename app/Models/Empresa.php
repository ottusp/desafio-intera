<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function processos() {
        return $this->hasMany('App\Models\Processo');
    }

    public function squads() {
        return $this->belongsToMany('App\Models\Squad');
    }
}

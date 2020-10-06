<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $squad)
 * @method static find($squadId)
 */
class Squad extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function processos() {
        return $this->hasMany('App\Models\Processo');
    }
}

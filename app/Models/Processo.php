<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($processo_id)
 * @method static where(string $string, $id)
 * @method static orWhere(string $string, $squadId)
 * @method static first()
 * @method static create(array $array)
 * @property mixed data_de_entrega
 */
class Processo extends Model
{
    use HasFactory;

    protected $attributes = [
        'tem_meta' => false,
    ];

    protected $guarded = [];

    public function empresa()
    {
        return $this->belongsTo('\App\Models\Empresa');
    }

    public function squad() {
        return $this->belongsTo('\App\Models\Squad');
    }

    public function getDiaDeEntregaAttribute() {

        $date = \DateTime::createFromFormat('Y/m/d', $this->data_de_entrega);
        return $date->format('d/m/Y');
    }
}

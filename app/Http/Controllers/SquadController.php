<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Squad;
use Illuminate\Http\Request;

class SquadController extends Controller
{
    public function pesquisaSquad() {
        $squads = Squad::all();

        return view('pesquisaSquad', compact('squads'));

    }

    public function squadMetas() {
        $data = request()->validate([
            'squadId' => 'required',
        ]);

        $squad = Squad::find($data['squadId']);

        $processos = Processo::where('squad_id', $squad->id)
            ->where('tem_meta', true)
            ->where('is_ativo', true)
            ->get();

        return view('visualizaMetas', compact('squad', 'processos'));
    }

}

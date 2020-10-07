<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetaRequest;
use App\Models\Processo;
use App\Models\Squad;
use DateTime;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{

    public function storeMeta(MetaRequest $metaRequest) {

        $processoId = request()->validate(['processo_id' => 'required|integer']);

        $data = $metaRequest->validated();

        $processo = Processo::find($processoId)->first();

        if($processo->tem_meta) {
            return redirect()
                ->back()
                ->with('erro', 'Uma meta já foi cadastrada para esse processo');
        }

        $data['data_de_entrega'] = DateTime::createFromFormat(
            'd/m/Y',
            $data['data_de_entrega'],
        );

        $processo->update($data);
        $processo->update(['tem_meta' => true]);

        return redirect()->back();
    }

    public function filtroProcessos() {
        $required = request()->validate([
            'squadId' => 'required|integer',
            'ordenarPor' => 'required',
        ]);

        $optional = request([
            'mostrarComMetas',
            'mostrarEncerrados'
        ]);

        $queryOptional = $this->getRawOptionalQuery($optional);

        $processos = Processo::where('squad_id', $required['squadId'])
            ->whereRaw($queryOptional)
            ->orderBy($required['ordenarPor'])
            ->get();

        $squad = Squad::find($required['squadId']);

        $possiveisDatasDeEntrega = $this->getProximasSextas(40);

        return view('selecionaProcesso', compact('squad', 'processos', 'possiveisDatasDeEntrega'));
    }

    public function ordenaMetas() {
        $required = request()->validate([
            'squadId' => 'required|integer',
            'ordenarPor' => 'required',
        ]);


        $processos = Processo::where('squad_id', $required['squadId'])
            ->where('is_ativo', true)
            ->where('tem_meta', true)
            ->orderBy($required['ordenarPor'])
            ->get();

        $squad = Squad::find($required['squadId']);

        return view('visualizaMetas', compact('squad', 'processos'));

    }

    public function getProcessosAtivosBySquad() {
        $data = request()->validate([
            'squad' => 'required',
        ]);

        $squad = Squad::where('nome', $data['squad'])->first();


        if($squad == null)
            return redirect()
                ->back()
                ->with('erro', 'Squad não encontrado');

        $processos = Processo::where('squad_id', $squad->id)
            ->where('is_ativo', true)
            ->where('tem_meta', false)
            ->orderBy('nome_da_empresa')
            ->get();

        $possiveisDatasDeEntrega = $this->getProximasSextas(40);

        return view('selecionaProcesso', compact('squad', 'processos', 'possiveisDatasDeEntrega'));
    }

    private function getRawOptionalQuery($optional) {
        $queryOptional = "(tem_meta = false AND is_ativo = true) OR (";
        if(array_key_exists('mostrarComMetas', $optional)) {
            $queryOptional .= 'tem_meta = true OR ';
        }
        if(array_key_exists('mostrarEncerrados', $optional)) {
            $queryOptional .= 'is_ativo = false)';
        }

        if(str_ends_with($queryOptional, ' OR '))
            $queryOptional = substr($queryOptional, 0, strlen($queryOptional) - 4). ')';
        else if(str_ends_with($queryOptional, ' OR ('))
            $queryOptional = substr($queryOptional, 0, strlen($queryOptional) - 5);

        return $queryOptional;
    }

    private function getProximasSextas($quantas) {
        $proximaSexta = $this->getProximaSexta();

        $sextas = [$proximaSexta->format('d/m/Y')];
        $intervalo = new \DateInterval('P7D');
        for($i = 1; $i < $quantas; $i++) {
            $sextas[] = $proximaSexta->add($intervalo)->format('d/m/Y');
        }

        return array_reverse($sextas);
    }

    private function getProximaSexta() {
        $dateTime = new \DateTime(
            'now',
            new \DateTimeZone('America/Sao_Paulo')
        );
        $day = $dateTime->format('N');

        $diferencaParaSexta = $day - 5;
        if($diferencaParaSexta < 0)
            $diferencaParaSexta = -$diferencaParaSexta;
        else
            $diferencaParaSexta = 7 - $diferencaParaSexta;

        $intervaloDeDias = new \DateInterval('P'. "{$diferencaParaSexta}" .'D');

        return $dateTime->add($intervaloDeDias);
    }
}

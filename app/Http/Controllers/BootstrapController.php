<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Processo;
use App\Models\Squad;

class BootstrapController extends Controller
{

    private $dadosCsv;

    public function index() {

        $this->carregaRelacoes();

        $this->criaSquads();
        $this->criaEmpresas();
        $this->criaProcessos();
        $this->criaMetas();

    }

    private function criaSquads() {
        if(Squad::all()->count() != 0) {
            Squad::query()->delete();
        }

        $contador = 1;

        for($i = 1; $i < count($this->dadosCsv); $i++) {
            $relacao = $this->dadosCsv[$i];
            $nomeDoSquad = $relacao['Squad'];

            $squad = Squad::where('nome', $nomeDoSquad)->first();

            if($squad === null) {
                Squad::create([
                    'id' => $contador,
                    'nome' => $nomeDoSquad,
                ]);

                $contador++;
            }

        }
    }

    private function criaEmpresas() {
        if(Empresa::all()->count() != 0) {
            Empresa::query()->delete();
        }

        $contador = 1;

        for($i = 1; $i < count($this->dadosCsv); $i++) {
            $relacao = $this->dadosCsv[$i];
            $nomeDaEmpresa = $relacao['Empresa'];

            $empresa = Empresa::where('nome', $nomeDaEmpresa)->first();

            if($empresa === null) {
                Empresa::create([
                    'id' => $contador,
                    'nome' => $nomeDaEmpresa,
                ]);

                $contador++;
            }

        }

    }

    private function criaProcessos() {
        if(Processo::all()->count() != 0) {
            Processo::query()->delete();
        }

        $contador = 1;

        for($i = 1; $i < count($this->dadosCsv); $i++) {
            $relacao = $this->dadosCsv[$i];
            $nomeDaVaga = $relacao['Vaga'];

            $empresa = Empresa::where('nome', $relacao['Empresa'])->first();
            $empresaId = $empresa->id;

            $squad = Squad::where('nome', $relacao['Squad'])->first();
            $squadId = $squad->id;

            $status = $relacao['Status'];
            $is_ativo = !strcmp($status, 'Ativa');

            Processo::create([
                'id' => $contador,
                'empresa_id' => $empresaId,
                'squad_id' => $squadId,
                'nome_da_vaga' => $nomeDaVaga,
                'nome_da_empresa' => $empresa->nome,
                'is_ativo' => $is_ativo,
            ]);

            $contador++;

        }
    }

    private function criaMetas() {
        $dataDeEntrega = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));

        $meta = [
            'tem_meta' => true,
            'inscricoes' => 50,
            'entrevistas' => 10,
            'aprovados' => 2,
            'data_de_entrega' => $dataDeEntrega,
        ];

        $processo = Processo::first()
            ->update($meta);
    }

    private function carregaRelacoes() {
        $path = '..\..\processos.csv';
        $linhasCsv = $this->carregaCsv($path);

        $this->dadosCsv = $linhasCsv;
    }

    private function carregaCsv($path) {
        $file = fopen($path, 'r');

        $dados = array();

        while(!feof($file)) {
            $dado = fgetcsv($file);

            $estrutura = [
                'Empresa' => $dado[0],
                'Vaga' => $dado[1],
                'Status' => $dado[2],
                'Squad' => $dado[3],
            ];
            $dados[] = $estrutura;
        }
        fclose($file);

        return $dados;
    }
}

@extends('baseTemplate')

@section('styles')

    <style>
        #barra-de-navegacao {
            display: block;

            padding-bottom: 1rem;

            border-bottom: 1px solid grey;
        }

        .campo-linha-inteira {
            width: 100%;
        }

        .botoes-container {
            display: flex;
        }

        .botao-container {
            text-align: end;
        }
    </style>

@endsection

@section('content')
    <section id="barra-de-navegacao" class="section">
        <div class="content">
            <form id="filtro-form"
                  action="/ordenaMetas" method="get">

                <div class="squad-container">
                    Squad: {{ $squad->nome }}
                    <input name="squadId" value="{{ $squad->id }}" hidden>
                </div>

                <div id="ordenar-por-container">
                    <label class="campo-linha-inteira" for="ordenar-por">
                        Ordenar por

                        <select name="ordenarPor" id="ordenar-por">
                            <option value="nome_da_empresa" selected>Empresa</option>
                            <option value="nome_da_vaga">Nome da vaga</option>
                            <option value="data_de_entrega">Data de entrega</option>
                            <option value="inscricoes">Incrições</option>
                            <option value="entrevistas">Entrevistas</option>
                            <option value="aprovados">Aprovados</option>
                        </select>
                    </label>
                </div>

                @csrf

            </form>

            <form id="consultar-processos-form" action="/processos" method="get">
                <input name="squad" value="{{ $squad->nome }}" hidden>
            </form>

            <div class="botoes-container">
                <div class="botao-container">
                    <button form="filtro-form">Filtrar</button>
                </div>

                <div class="botao-container">
                    <button form="consultar-processos-form">Consultar processos</button>
                </div>
            </div>

        </div>
    </section>

    <section class="section">
        <div class="content">
            @if(count($processos->modelKeys()) == 0)
                <div id="nao-ha-processos-container">
                    Não há processos com metas cadastradas
                </div>
            @else
                <table>
                    <tr>
                        <th>Empresa</th>
                        <th>Vaga</th>
                        <th>Inscrições</th>
                        <th>Entrevistas</th>
                        <th>Aprovados</th>
                        <th>Entrega</th>
                    </tr>

                    <div hidden>{{ $i = 0 }}</div>
                    @forelse($processos as $processo)
                        <tr>
                            <td>{{ $processo->empresa->nome }}</td>
                            <td>{{ $processo->nome_da_vaga }}</td>
                            <td>{{ $processo->inscricoes }}</td>
                            <td>{{ $processo->entrevistas }}</td>
                            <td>{{ $processo->aprovados }}</td>
                            <td>{{ $processo->dia_de_entrega }}</td>
                        </tr>
                        <div hidden>{{ $i++ }}</div>
                    @empty
                        <h1>Hahaha</h1>
                    @endforelse

                </table>
            @endif
        </div>
    </section>
@endsection

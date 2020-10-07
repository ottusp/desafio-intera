@extends('baseTemplate')

@section('imports')

    <link rel="stylesheet" href="{{ asset('styles/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/tabela.css') }}">

@endsection


@section('content')

    <section id="menu" class="section">
        <div class="content">
            <form id="filtro-form"
                  action="/ordenaMetas" method="get">

                <div class="squad-name">
                    Squad: {{ $squad->nome }}
                    <input name="squadId" value="{{ $squad->id }}" hidden>
                </div>

                <div class="clickable-filters-container">
                    <div id="ordenar-por-container">
                        <label for="ordenar-por">
                            Ordenar por

                            <select name="ordenarPor" id="ordenar-por">
                                <option value="nome_da_empresa" selected>Empresa</option>
                                <option value="nome_da_vaga">Nome da vaga</option>
                                <option value="inscricoes">Incrições</option>
                                <option value="entrevistas">Entrevistas</option>
                                <option value="aprovados">Aprovados</option>
                                <option value="data_de_entrega">Data de entrega</option>
                            </select>
                        </label>
                    </div>

                </div>

                <div class="botao-container">
                    <button form="filtro-form" class="intera-button">Aplicar</button>
                </div>

                @csrf

            </form>

            <form id="consultar-processos-form" class="muda-pagina-form" action="/processos" method="get">
                <input name="squad" value="{{ $squad->nome }}" hidden>
                <div class="botao-container">
                    <button id="consultar-metas-button" class="intera-button menu-button" >
                        Consultar processos
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

        </div>
    </section>

    <section id="tabela" class="section">
        <div class="content">
            @if(count($processos->modelKeys()) == 0)
                <div id="nao-ha-processos-container">
                    Não há processos com metas cadastradas
                </div>
            @else
                <table>
                    <tr id="header-row">
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

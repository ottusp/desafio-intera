@extends('baseTemplate')

@section('imports')
    <link rel="stylesheet" href="{{ asset('styles/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/tabela.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/modal.css') }}">

    <script defer src="{{ asset('scripts/selecionaProcesso.js') }}"></script>
@endsection

@section('scripts')

    <script>

        let squad = '{{ $squad->nome }}';
        let empresas = [];
        let vagas = [];
        let processosIds = [];

        document.addEventListener("DOMContentLoaded", () => {
            let i = 0;

            @foreach($processos as $processo)
                empresas[i] = '{{ $processo->empresa->nome }}';
                vagas[i] = '{{ $processo->nome_da_vaga }}';
                processosIds[i] = {{ $processo->id }};
                i++;
            @endforeach

        });

    </script>

@endsection


@section('content')

    @if($errors->any())
        @include('partials.popUpErro', array('errors' => $errors))
    @endif

    <section id="menu" class="section">
        <div class="content">
            <form id="filtro-form"
                  action="/filtroProcessos" method="get">

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
                                <option value="is_ativo">Status</option>
                            </select>
                        </label>
                    </div>


                    <div id="com-metas-container">
                        <input name="mostrarComMetas" id="mostrar-com-metas" type="checkbox">
                        <label for="mostrar-com-metas">Mostrar processos com metas definidas</label>
                    </div>

                    <div id="encerrados-container">
                        <input name="mostrarEncerrados" id="mostrar-encerrados" type="checkbox">
                        <label for="mostrar-encerrados">Mostrar processos encerrados</label>
                    </div>

                </div>

                <div class="botao-container">
                    <button form="filtro-form" class="intera-button">Aplicar</button>
                </div>

                @csrf

            </form>

            <form id="consultar-metas-form" class="muda-pagina-form" action="/squadMetas" method="get">
                <input name="squadId" value="{{ $squad->id }}" hidden>
                <div class="botao-container">
                    <button id="consultar-metas-button" class="intera-button menu-button" >
                        Consultar metas
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

        </div>
    </section>

    <section id="tabela" class="section">
        <div class="content">
            <table>
                <thead>
                    <tr id="header-row">
                        <th>Empresa</th>
                        <th>Vaga</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <div hidden>{{ $i = 0 }}</div>
                @foreach($processos as $processo)
                    <tr ontoggle="adicionaOpcoesDeCadastro({{ $processo->id }})">
                        <td>{{ $processo->empresa->nome }}</td>
                        <td>{{ $processo->nome_da_vaga }}</td>
                        <td>{{ !$processo->is_ativo ? 'Encerrado' : ($processo->tem_meta ? 'Meta cadastrada' : 'Meta não cadastrada')}}</td>

                        @if($processo->is_ativo && !$processo->tem_meta)
                            <td class="celula-sem-borda">
                                <button class="tabela-button intera-button"
                                        onclick="mostraCadastro({{ $i }})">
                                    Definir meta
                                </button>
                            </td>
                        @endif
                    </tr>
                    <div hidden>{{ $i++ }}</div>
                @endforeach

            </table>
        </div>
    </section>

    <section id="modal-section" class="section">
        <div class="content">
            <div id="modal" class="modal">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Definir meta</p>
                        <button onclick="toggleCadastro()" class="delete" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">

                        <form id="cadastro-da-meta-form" action="/storeMeta" method="post">

                            <table>
                                <tbody>
                                <tr>
                                    <td><b>Squad</b>:</td>
                                    <td><div id="modal-squad-container"></div></td>
                                </tr>

                                <tr>
                                    <td><b>Empresa</b>:</td>
                                    <td><div id="modal-empresa-container"></div></td>
                                </tr>

                                <tr>
                                    <td><b>Vaga</b>:</td>
                                    <td><div id="modal-vaga-container"></div></td>
                                </tr>

                                <tr>
                                    <td><b>Inscrições</b>:</td>
                                    <td><input id="inscricoes" class="intera-input" name="inscricoes" type="text" autocomplete="off" required></td>
                                </tr>

                                <tr>
                                    <td><b>Entrevistas</b>:</td>
                                    <td>
                                        <input id="entrevistas" class="intera-input" name="entrevistas" type="text" autocomplete="off" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Aprovados</b>:</td>
                                    <td>
                                        <input id="aprovados" class="intera-input" name="aprovados" type="text" autocomplete="off" required>
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Última sexta-feira de entrega</b>:</td>
                                    <td>
                                        <select id="data_de_entrega" class="intera-input" name="data_de_entrega" required>
                                            @foreach($possiveisDatasDeEntrega as $dataDeEntrega)
                                                <option value="{{ $dataDeEntrega }}">{{ $dataDeEntrega }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                </tbody>
                            </table>

                            <input id="processo-id-input" name="processo_id" hidden>

                            @csrf
                        </form>

                    </section>
                    <footer class="modal-card-foot">
                        <button form="cadastro-da-meta-form" class="button is-success">Salvar meta</button>
                        <button onclick="toggleCadastro()" class="button is-danger">Cancelar</button>
                    </footer>
                </div>
            </div>
        </div>
    </section>

@endsection

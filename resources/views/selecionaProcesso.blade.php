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

        #checkbox-container {
            display: block;
        }

        .botao-container {
            text-align: end;
        }
    </style>
@endsection

@section('scripts')
    <script defer>

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

        function toggleCadastro() {
            let modal = document.getElementById('modal');

            if(modal.classList.contains('is-active')) {
                modal.classList.remove('is-active');
            } else {
                modal.classList.add('is-active');
            }
        }

        function mostraCadastro(index) {
            let squadContainer = document.getElementById('modal-squad-container');
            squadContainer.innerHTML = `Squad: ${squad}`;

            let empresaContainer = document.getElementById('modal-empresa-container');
            empresaContainer.innerHTML = `Empresa: ${empresas[index]}`;

            let vagaContainer = document.getElementById('modal-vaga-container');
            vagaContainer.innerHTML = `Vaga: ${vagas[index]}`;

            let processoInput = document.getElementById('processo-id-input');
            processoInput.setAttribute('value', processosIds[index]);

            toggleCadastro();
        }

        function fechaPopUp() {
            let popUp = document.getElementById('pop-up-container');
            popUp.style.display = 'none';
        }

    </script>

@endsection


@section('content')

    @if(session('erro'))
        @include('partials.popUpErro')
    @endif

    <section id="barra-de-navegacao" class="section">
        <div class="content">
            <form id="filtro-form"
                  action="/filtroProcessos" method="get">

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
                            <option value="is_ativo">Status</option>
                        </select>
                    </label>
                </div>


                <div id="checkbox-container">
                    <div id="com-metas-container">
                        <input name="mostrarComMetas" id="mostrar-com-metas" type="checkbox">
                        <label for="mostrar-com-metas">Mostrar processos com metas definidas</label>
                    </div>

                    <div id="encerrados-container">
                        <input name="mostrarEncerrados" id="mostrar-encerrados" type="checkbox">
                        <label for="mostrar-encerrados">Mostrar processos encerrados</label>
                    </div>

                </div>

                @csrf

            </form>

            <form id="consultar-metas-form" action="/squadMetas" method="get">
                <input name="squadId" value="{{ $squad->id }}" hidden>
            </form>

            <div class="botoes-container">
                <div class="botao-container">
                    <button form="filtro-form">Filtrar</button>
                </div>

                <div class="botao-container">
                    <button form="consultar-metas-form">Consultar metas</button>
                </div>
            </div>

        </div>
    </section>

    <section class="section">
        <div class="content">
            <table>
                <tr>
                    <th>Empresa</th>
                    <th>Vaga</th>
                    <th>Status</th>
                </tr>

                <div hidden>{{ $i = 0 }}</div>
                @foreach($processos as $processo)
                    <tr ontoggle="adicionaOpcoesDeCadastro({{ $processo->id }})">
                        <td>{{ $processo->empresa->nome }}</td>
                        <td>{{ $processo->nome_da_vaga }}</td>
                        <td>{{ !$processo->is_ativo ? 'Encerrado' : ($processo->tem_meta ? 'Meta cadastrada' : 'Meta não cadastrada')}}</td>

                        @if($processo->is_ativo && !$processo->tem_meta)
                            <td>
                                <button onclick="mostraCadastro({{ $i }})">Definir meta</button>
                            </td>
                        @endif
                    </tr>
                    <div hidden>{{ $i++ }}</div>
                @endforeach

            </table>

            <div id="modal" class="modal">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Definir meta</p>
                        <button onclick="toggleCadastro()" class="delete" aria-label="close"></button>
                    </header>
                    <section class="modal-card-body">
                        <form id="cadastro-da-meta-form" action="/storeMeta" method="post">
                            <div id="modal-squad-container" class="squad-container"></div>
                            <div id="modal-empresa-container" class="empresa-container"></div>
                            <div id="modal-vaga-container" class="vaga-container"></div>

                            <div class="inscricoes-container">
                                <label>Inscrições:
                                    <input id="inscricoes" name="inscricoes" type="text" autocomplete="off" required>
                                </label>
                            </div>

                            <div class="entrevistas-container">
                                <label>Entrevistas:
                                    <input id="entrevistas" name="entrevistas" type="text" autocomplete="off" required>
                                </label>
                            </div>

                            <div class="aprovados-container">
                                <label>Aprovados:
                                    <input id="aprovados" name="aprovados" type="text" autocomplete="off" required>
                                </label>
                            </div>

                            <div class="entrega-container">
                                <label>Última sexta-feira para entrega:
                                    <select id="data_de_entrega" name="data_de_entrega" required>
                                        @foreach($possiveisDatasDeEntrega as $dataDeEntrega)
                                            <option value="{{ $dataDeEntrega }}">{{ $dataDeEntrega }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            <input id="processo-id-input" name="processo_id" hidden>

                            @csrf
                        </form>
                    </section>
                    <footer class="modal-card-foot">
                        <button form="cadastro-da-meta-form" class="button is-success">Salvar meta</button>
                        <button class="button is-danger">Cancelar</button>
                    </footer>
                </div>
            </div>

        </div>
    </section>

@endsection

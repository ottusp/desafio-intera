@extends('baseTemplate')

@section('imports')

    <link rel="stylesheet" href="{{ asset('styles/pesquisaSquad.css') }}">

@endsection

@section('content')

<section id="pesquisa-squad" class="section">
    <div id="main-container" class="content">
        <div class="escolha-squad-container">
            <div class="title-container">
                <h1 class="title">Escolha seu Squad</h1>
            </div>

            <div class="form-container">
                <form action="/processos" method="get" autocomplete="off">
                    <div class="input-container">
                        <input list="squads" class="intera-input" name="squad" type="text" placeholder="Ex: Grifinória">

                        <datalist id="squads">
                            @foreach($squads as $squad)
                                <option value="{{ $squad->nome }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="button-container">
                        <button class="intera-button" >Pesquisar</button>
                    </div>


                    @csrf
                </form>

                @if(session('erro'))
                    <p>{{ session('erro') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

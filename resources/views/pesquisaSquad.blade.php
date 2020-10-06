@extends('baseTemplate')

@section('content')

    <h1>Escolha seu Squad</h1>

    <form action="/processos" method="get" autocomplete="off">
        <label for="squad">Squad</label>
        <input list="squads" id="squad" name="squad" type="text">

        <datalist id="squads">
            @foreach($squads as $squad)
                <option value="{{ $squad->nome }}">
            @endforeach
        </datalist>

        <button>Pesquisar</button>

        @csrf
    </form>

    @if(session('erro'))
        <p>{{ session('erro') }}</p>
    @endif

@endsection

@extends('layouts.app')

@section('content')

<h4>Novo Produto</h4>

<form method="POST" action="{{ route('products.store') }}">
    @csrf

    <input type="text" name="nome" placeholder="Nome" class="form-control mb-2">

    <input type="number" step="0.01" name="preco" placeholder="Preço" class="form-control mb-2">

    <textarea name="descricao" class="form-control mb-2" placeholder="Descrição"></textarea>

    <button class="btn btn-success">Salvar</button>
</form>

@endsection

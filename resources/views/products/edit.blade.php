@extends('layouts.app')

@section('content')

<h4>Editar Produto</h4>

<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf
    @method('PUT')

    <input type="text" name="nome" value="{{ $product->nome }}" class="form-control mb-2">

    <input type="number" step="0.01" name="preco" value="{{ $product->preco }}" class="form-control mb-2">

    <textarea name="descricao" class="form-control mb-2">
        {{ $product->descricao }}
    </textarea>

    <button class="btn btn-primary">Atualizar</button>
</form>

@endsection

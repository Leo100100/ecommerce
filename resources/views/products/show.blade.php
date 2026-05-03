@extends('layouts.app')
@section('title', $product->nome)

@section('content')
<div class="d-flex align-items-center mb-4 gap-2">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">← Voltar</a>
    <h4 class="mb-0">{{ $product->nome }}</h4>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $product->id }}</dd>

            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $product->nome }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $product->descricao ?? '—' }}</dd>

            <dt class="col-sm-3">Preço</dt>
            <dd class="col-sm-9">R$ {{ number_format($product->preco, 2, ',', '.') }}</dd>

            <dt class="col-sm-3">Estoque</dt>
            <dd class="col-sm-9">{{ $product->estoque }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if($product->ativo)
                    <span class="badge bg-success">Ativo</span>
                @else
                    <span class="badge bg-secondary">Inativo</span>
                @endif
            </dd>
        </dl>
    </div>
</div>
@endsection

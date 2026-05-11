@extends('layouts.app')
@section('title', 'Novo Pedido')

@section('content')
<div class="container">
    <h4>Novo Pedido</h4>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf


        <div class="mb-3">
            <label>Cliente</label>
            <p class="form-control-plaintext">
                {{ auth()->user()->name }}
            </p>
        </div>


        <div class="mb-3">
            <label>Total</label>
            <input type="number" step="0.01" name="total" class="form-control" required>
        </div>

        
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pendente">Pendente</option>
                <option value="confirmado">Confirmado</option>
            </select>
        </div>

        <button class="btn btn-success">Salvar</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

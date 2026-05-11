@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')

<div style="font-size:.8rem;color:#666;margin-bottom:8px;">
    <a href="{{ route('products.index') }}" style="color:#0066cc;text-decoration:none;">Produtos</a>
    &rsaquo; {{ Str::limit($product->nome, 40) }}
    &rsaquo; Editar
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="ec-page-title">Editar Produto</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('products.show', $product) }}" class="btn-ec-outline">
            <i class="bi bi-eye"></i> Ver produto
        </a>
        <a href="{{ route('products.index') }}" class="btn-ec-ghost">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>
</div>

@if($errors->any())
    <div class="ec-alert ec-alert-danger mb-4">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>
            <strong>Corrija os erros abaixo:</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('products.update', $product) }}" id="productForm">
    @csrf
    @method('PUT')

    <div class="row g-4">

        {{-- Coluna principal --}}
        <div class="col-lg-8">

            {{-- Informações básicas --}}
            <div class="ec-card p-4 mb-4">
                <h6 style="font-weight:bold;margin-bottom:16px;">Informações Básicas</h6>

                <div class="mb-3">
                    <label for="nome" style="font-size:.875rem;font-weight:600;display:block;margin-bottom:5px;">
                        Nome do produto <span style="color:#cc0000;">*</span>
                    </label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome', $product->nome) }}"
                        placeholder="Ex: Camiseta Básica"
                        class="ec-form-control @error('nome') is-invalid @enderror"
                        autofocus
                    >
                    @error('nome')
                        <span style="font-size:.8rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="descricao" style="font-size:.875rem;font-weight:600;display:block;margin-bottom:5px;">
                        Descrição
                    </label>
                    <textarea
                        id="descricao"
                        name="descricao"
                        rows="5"
                        placeholder="Descreva o produto..."
                        class="ec-form-control @error('descricao') is-invalid @enderror"
                        style="resize:vertical;"
                    >{{ old('descricao', $product->descricao) }}</textarea>
                    @error('descricao')
                        <span style="font-size:.8rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Preço e Estoque --}}
            <div class="ec-card p-4">
                <h6 style="font-weight:bold;margin-bottom:16px;">Preço e Estoque</h6>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="preco_display" style="font-size:.875rem;font-weight:600;display:block;margin-bottom:5px;">
                            Preço <span style="color:#cc0000;">*</span>
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#888;font-size:.875rem;pointer-events:none;">R$</span>
                            <input
                                type="text"
                                id="preco_display"
                                inputmode="numeric"
                                placeholder="0,00"
                                class="ec-form-control @error('preco') is-invalid @enderror"
                                style="padding-left:32px;"
                                autocomplete="off"
                            >
                        </div>
                        <input type="hidden" id="preco" name="preco" value="{{ old('preco', $product->preco) }}">
                        @error('preco')
                            <span style="font-size:.8rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label for="estoque" style="font-size:.875rem;font-weight:600;display:block;margin-bottom:5px;">
                            Estoque <span style="color:#cc0000;">*</span>
                        </label>
                        <input
                            type="number"
                            id="estoque"
                            name="estoque"
                            value="{{ old('estoque', $product->estoque) }}"
                            min="0"
                            step="1"
                            placeholder="0"
                            class="ec-form-control @error('estoque') is-invalid @enderror"
                        >
                        @error('estoque')
                            <span style="font-size:.8rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Coluna lateral --}}
        <div class="col-lg-4">

            {{-- Metadados --}}
            <div class="ec-card p-4 mb-4" style="font-size:.8rem;color:#666;">
                <div class="d-flex justify-content-between mb-1">
                    <span>ID</span>
                    <span style="color:#333;font-weight:600;">#{{ $product->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span>Criado em</span>
                    <span style="color:#333;">{{ $product->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Atualizado</span>
                    <span style="color:#333;">{{ $product->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            {{-- Status --}}
            <div class="ec-card p-4 mb-4">
                <h6 style="font-weight:bold;margin-bottom:14px;">Status</h6>

                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.875rem;">
                    <input
                        type="checkbox"
                        id="ativo"
                        name="ativo"
                        value="1"
                        {{ old('ativo', $product->ativo) ? 'checked' : '' }}
                    >
                    Produto ativo (visível na loja)
                </label>
            </div>

            {{-- Ações --}}
            <div class="ec-card p-4">
                <button type="submit" class="btn-ec-primary w-100 justify-content-center mb-2" style="width:100%;">
                    <i class="bi bi-check-lg"></i> Salvar Alterações
                </button>
                <a href="{{ route('products.show', $product) }}" class="btn-ec-ghost w-100 justify-content-center" style="width:100%;">
                    Cancelar
                </a>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
(function () {
    const display = document.getElementById('preco_display');
    const hidden  = document.getElementById('preco');

    function formatBRL(cents) {
        return (cents / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    display.addEventListener('input', function () {
        const digits = this.value.replace(/\D/g, '').replace(/^0+/, '') || '0';
        const cents  = parseInt(digits, 10);
        this.value   = formatBRL(cents);
        hidden.value = (cents / 100).toFixed(2);
    });

    display.addEventListener('focus', function () {
        if (this.value === '') this.value = '0,00';
    });

    if (hidden.value) {
        const cents = Math.round(parseFloat(hidden.value) * 100);
        display.value = formatBRL(cents);
    }
})();
</script>
@endpush

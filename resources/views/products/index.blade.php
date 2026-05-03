@extends('layouts.app')

@section('title', 'Produtos')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0">Produtos</h4>

    <a href="{{ route('products.create') }}" class="btn btn-primary">
        Novo Produto
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->nome }}</td>
                    <td>R$ {{ number_format($product->preco, 2, ',', '.') }}</td>
                    <td>{{ $product->estoque }}</td>

                    <td>
                        @if($product->ativo)
                            <span class="badge bg-success">Ativo</span>
                        @else
                            <span class="badge bg-secondary">Inativo</span>
                        @endif
                    </td>

                    <td class="text-center">

                        {{-- VER --}}
                        <a href="{{ route('products.show', $product) }}"
                           class="btn btn-sm btn-outline-primary">
                            Ver
                        </a>

                        {{-- EDITAR --}}
                        <a href="{{ route('products.edit', $product) }}"
                           class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        {{-- EXCLUIR --}}
                        <form action="{{ route('products.destroy', $product) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja realmente excluir este produto?')">
                                Excluir
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Nenhum produto cadastrado.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    @if($products->hasPages())
    <div class="card-footer">
        {{ $products->links() }}
    </div>
    @endif

</div>

@endsection

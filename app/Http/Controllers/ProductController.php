<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::where('user_id', auth()->id());
        // dd($products->toRawSql());

        $products = Product::where('user_id', auth()->id())->paginate(40);

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'     => 'required|string|max:255',
            'descricao'=> 'nullable|string',
            'preco'    => 'required|numeric|min:0',
            'estoque'  => 'required|integer|min:0',
            'ativo'    => 'nullable|boolean',
        ]);

        $validated['ativo'] = $request->boolean('ativo');
        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'nome'     => 'required|string|max:255',
            'descricao'=> 'nullable|string',
            'preco'    => 'required|numeric|min:0',
            'estoque'  => 'required|integer|min:0',
            'ativo'    => 'nullable|boolean',
        ]);

        $validated['ativo'] = $request->boolean('ativo');

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        abort_if($product->user_id !== auth()->id(), 403);

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produto excluído com sucesso');
    }
    public function shop()
    {
        $products = Product::where('ativo', true)->get();
        return view('shop.index', compact('products'));
    }

    public function showShop(Product $product)
    {
        return view('shop.show', compact('product'));
    }
    // TODO (candidato): implementar create, store, edit, update, destroy
}

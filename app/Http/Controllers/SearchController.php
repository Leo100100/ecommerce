<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q      = trim($request->get('q', ''));
        $sort   = $request->get('sort', 'relevancia');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $query = Product::where('ativo', true);

        if ($q !== '') {
            $query->where(function ($q2) use ($q) {
                $q2->where('nome', 'like', "%{$q}%")
                   ->orWhere('descricao', 'like', "%{$q}%");
            });
        }

        if ($minPrice !== null && $minPrice !== '') {
            $query->where('preco', '>=', $minPrice);
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('preco', '<=', $maxPrice);
        }

        match ($sort) {
            'preco_asc'  => $query->orderBy('preco', 'asc'),
            'preco_desc' => $query->orderBy('preco', 'desc'),
            'nome_asc'   => $query->orderBy('nome', 'asc'),
            'nome_desc'  => $query->orderBy('nome', 'desc'),
            'recentes'   => $query->orderBy('created_at', 'desc'),
            default      => $q !== ''
                ? $query->orderByRaw("CASE WHEN nome LIKE ? THEN 0 ELSE 1 END", ["%{$q}%"])
                : $query->orderBy('nome', 'asc'),
        };

        $products = $query->paginate(40)->withQueryString();

        return view('search.index', compact('products', 'q', 'sort', 'minPrice', 'maxPrice'));
    }

    public function live(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 3) {
            return response()->json([]);
        }

        $products = Product::where('ativo', true)
            ->where(function ($query) use ($q) {
                $query->where('nome', 'like', "%{$q}%")
                      ->orWhere('descricao', 'like', "%{$q}%");
            })
            ->orderByRaw("CASE WHEN nome LIKE ? THEN 0 ELSE 1 END", ["%{$q}%"])
            ->limit(6)
            ->get(['id', 'nome', 'preco']);

        return response()->json($products);
    }
}

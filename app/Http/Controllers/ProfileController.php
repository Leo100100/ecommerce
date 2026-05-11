<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user           = Auth::user()->load('addresses', 'paymentMethods');
        $addresses      = $user->addresses()->orderByDesc('principal')->orderBy('apelido')->get();
        $paymentMethods = $user->paymentMethods()->orderByDesc('principal')->orderBy('apelido')->get();

        return view('profile.index', compact('user', 'addresses', 'paymentMethods'));
    }

    public function updateDados(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$user->id}"],
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.index')
            ->with('success', 'Dados atualizados com sucesso!');
    }

    public function updateSenha(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Senha alterada com sucesso!');
    }

    public function storeEndereco(Request $request): RedirectResponse
    {
        $request->validate([
            'apelido'     => ['required', 'string', 'max:60'],
            'cep'         => ['required', 'string', 'max:9'],
            'logradouro'  => ['required', 'string', 'max:255'],
            'numero'      => ['required', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro'      => ['required', 'string', 'max:100'],
            'cidade'      => ['required', 'string', 'max:100'],
            'estado'      => ['required', 'string', 'size:2'],
        ]);

        $user = Auth::user();

        $isPrimeiro = $user->addresses()->count() === 0;

        $user->addresses()->create(array_merge(
            $request->only('apelido', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado'),
            ['principal' => $isPrimeiro]
        ));

        return redirect()->route('profile.index')
            ->with('success', 'Endereço adicionado!');
    }

    public function destroyEndereco(Address $address): RedirectResponse
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $eraPrincipal = $address->principal;
        $address->delete();

        if ($eraPrincipal) {
            Auth::user()->addresses()->first()?->update(['principal' => true]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Endereço removido!');
    }

    public function setPrincipal(Address $address): RedirectResponse
    {
        abort_if($address->user_id !== Auth::id(), 403);

        Auth::user()->addresses()->update(['principal' => false]);
        $address->update(['principal' => true]);

        return redirect()->route('profile.index')
            ->with('success', 'Endereço principal atualizado!');
    }

    public function storeCartao(Request $request): RedirectResponse
    {
        $request->validate([
            'apelido'       => ['required', 'string', 'max:60'],
            'bandeira'      => ['required', 'string', 'max:20'],
            'titular'       => ['required', 'string', 'max:100'],
            'numero_cartao' => ['required', 'string', 'min:19', 'max:19'],
            'validade'      => ['required', 'string', 'size:5'],
        ]);

        $user = Auth::user();
        $isPrimeiro = $user->paymentMethods()->count() === 0;
        $ultimos = substr(str_replace(' ', '', $request->numero_cartao), -4);

        $user->paymentMethods()->create([
            'apelido'         => $request->apelido,
            'bandeira'        => $request->bandeira,
            'titular'         => $request->titular,
            'ultimos_digitos' => $ultimos,
            'validade'        => $request->validade,
            'principal'       => $isPrimeiro,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Cartão adicionado!');
    }

    public function destroyCartao(PaymentMethod $paymentMethod): RedirectResponse
    {
        abort_if($paymentMethod->user_id !== Auth::id(), 403);

        $eraPrincipal = $paymentMethod->principal;
        $paymentMethod->delete();

        if ($eraPrincipal) {
            Auth::user()->paymentMethods()->first()?->update(['principal' => true]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Cartão removido!');
    }

    public function setPrincipalCartao(PaymentMethod $paymentMethod): RedirectResponse
    {
        abort_if($paymentMethod->user_id !== Auth::id(), 403);

        Auth::user()->paymentMethods()->update(['principal' => false]);
        $paymentMethod->update(['principal' => true]);

        return redirect()->route('profile.index')
            ->with('success', 'Cartão principal atualizado!');
    }
}

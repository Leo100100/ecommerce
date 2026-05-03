@extends('layouts.guest')
@section('title', 'Recuperar Senha')

@section('content')
<h5 class="card-title mb-3">Recuperar senha</h5>
<p class="text-muted small mb-4">Informe seu e-mail para receber o link de redefinição de senha.</p>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Enviar link</button>
    </div>
    <div class="text-center mt-3 small">
        <a href="{{ route('login') }}">← Voltar ao login</a>
    </div>
</form>
@endsection

@extends('layouts.guest')
@section('title', 'Confirmar Senha')

@section('content')
<h5 class="card-title mb-3">Confirmar senha</h5>
<p class="text-muted small mb-4">Por segurança, confirme sua senha para continuar.</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="current-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>
</form>
@endsection

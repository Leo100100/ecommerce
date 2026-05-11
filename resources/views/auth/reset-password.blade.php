@extends('layouts.guest')
@section('title', 'Redefinir Senha')

@section('content')
<h5 class="card-title mb-4">Redefinir senha</h5>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $request->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nova senha</label>
        <input id="password" type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar nova senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               class="form-control" required autocomplete="new-password">
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Redefinir senha</button>
    </div>
</form>
@endsection

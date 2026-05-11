@extends('errors.layout')

@section('error-title-tab', 'Sessão expirada')

@section('error-icon')
    <i class="bi bi-clock-history"></i>
@endsection

@section('error-heading', 'Sessão expirada')
@section('error-desc', 'Sua sessão expirou. Por favor, volte e tente novamente.')

@section('error-extra-action')
    <a href="javascript:history.back()" class="btn-ec-ghost">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
@endsection

@extends('errors.layout')

@section('error-title-tab', 'Acesso Negado')

@section('error-icon')
    <i class="bi bi-shield-lock-fill"></i>
@endsection

@section('error-heading', 'Ops! Não foi Possível Acessar essa Página')
@section('error-desc', $exception?->getMessage() ?: 'Você não tem permissão para visualizar este conteúdo.')

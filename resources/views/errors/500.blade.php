@extends('errors.layout')

@section('error-title-tab', 'Erro interno')

@section('error-icon')
    <i class="bi bi-exclamation-triangle-fill"></i>
@endsection

@section('error-heading', 'Algo deu errado')
@section('error-desc', 'Ocorreu um erro interno no servidor. Tente novamente em instantes.')

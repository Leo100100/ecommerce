@extends('errors.layout')

@section('error-title-tab', 'Muitas tentativas')

@section('error-icon')
    <i class="bi bi-stopwatch-fill"></i>
@endsection

@section('error-heading', 'Muitas tentativas')
@section('error-desc', 'Você fez requisições demais em pouco tempo. Aguarde alguns instantes e tente novamente.')

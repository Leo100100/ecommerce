@extends('layouts.app')

@section('title', 'Pagamento')

@section('content')

<div class="container py-5">

    <div class="ec-card p-4 mx-auto" style="max-width:700px;">

        <h2 class="mb-4">Pagamento gerado com sucesso</h2>

        @if($billingType === 'PIX')

            <div class="alert alert-success">
                Escaneie o QR Code abaixo para pagar.
            </div>

            <img src="{{ $payment['invoiceUrl'] }}"
                 alt="QR Code PIX"
                 style="width:100%;max-width:300px;">

            <div class="mt-4">
                <a href="{{ $payment['invoiceUrl'] }}"
                   target="_blank"
                   class="btn btn-primary">
                    Abrir cobrança PIX
                </a>
            </div>

        @endif

        @if($billingType === 'BOLETO')

            <div class="alert alert-warning">
                Seu boleto foi gerado.
            </div>

            <a href="{{ $payment['bankSlipUrl'] }}"
               target="_blank"
               class="btn btn-dark">
                Baixar boleto
            </a>

        @endif

    </div>

</div>

@endsection

@extends('layouts.app')
@section('title', 'Finalizar Compra')

@push('styles')
<style>
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .checkout-grid { grid-template-columns: 1fr; }
    }

    .co-panel {
        background: #fff;
        border: 1px solid #ddd;
        margin-bottom: 16px;
    }

    .co-panel-title {
        padding: 12px 16px;
        font-weight: bold;
        font-size: 0.9rem;
        border-bottom: 1px solid #ddd;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .co-panel-body { padding: 16px; }

    .co-label {
        display: block;
        font-size: 0.8rem;
        color: #555;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .co-input {
        width: 100%;
        border: 1px solid #ccc;
        padding: 8px 10px;
        font-size: 0.875rem;
        color: #333;
        background: #fff;
        outline: none;
        margin-bottom: 12px;
    }

    .co-input:focus { border-color: #0066cc; }

    .co-row { display: flex; gap: 12px; }
    .co-row > div { flex: 1; }

    .address-option {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #ddd;
        margin-bottom: 8px;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .address-option input[type="radio"] { margin-top: 2px; flex-shrink: 0; }
    .address-option-label { font-weight: 600; color: #333; margin-bottom: 2px; }
    .address-option-text  { color: #666; font-size: 0.8rem; line-height: 1.5; }

    .delivery-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #ddd;
        margin-bottom: 8px;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .delivery-option input[type="radio"] { flex-shrink: 0; }
    .delivery-option-label { font-weight: 600; flex: 1; }
    .delivery-option-date  { font-size: 0.78rem; color: #067D62; font-weight: 600; }

    .card-preview {
        background: #232F3E;
        color: #fff;
        padding: 20px;
        margin-bottom: 16px;
        font-family: monospace;
    }

    .card-preview-number { font-size: 1.1rem; letter-spacing: 3px; margin-bottom: 12px; }
    .card-preview-row    { display: flex; justify-content: space-between; font-size: 0.8rem; color: #aaa; }
    .card-preview-val    { color: #fff; font-weight: bold; }

    .payment-option {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #ddd;
        margin-bottom: 8px;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .payment-option input[type="radio"] { margin-top: 2px; flex-shrink: 0; }
    .payment-option-label { font-weight: 600; color: #333; margin-bottom: 2px; }
    .payment-option-text  { color: #666; font-size: 0.8rem; font-family: monospace; }

    .summary-item {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        padding: 6px 0;
        border-bottom: 1px solid #eee;
        color: #333;
    }

    .summary-item:last-child { border-bottom: none; }
    .summary-item-name { flex: 1; padding-right: 8px; color: #555; }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 1rem;
        padding: 12px 0 0;
        margin-top: 4px;
        border-top: 2px solid #ddd;
    }
</style>
@endpush

@section('content')

<div style="font-size:.8rem;color:#666;margin-bottom:8px;">
    <a href="{{ route('cart.index') }}" style="color:#0066cc;text-decoration:none;">Carrinho</a>
    &rsaquo; Finalizar compra
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="ec-page-title">Finalizar Compra</h1>
    <a href="{{ route('cart.index') }}" class="btn-ec-ghost">
        <i class="bi bi-arrow-left"></i> Voltar ao carrinho
    </a>
</div>

<form action="{{ route('checkout.store') }}" method="POST">
@csrf
<input type="hidden" name="frete_valor" id="freteValorInput" value="{{ $deliveryOptions[0]['frete'] }}">

<div class="checkout-grid">

    {{-- COLUNA PRINCIPAL --}}
    <div>

        {{-- ENDEREÇO DE ENTREGA --}}
        <div class="co-panel">
            <div class="co-panel-title">
                <i class="bi bi-geo-alt"></i> Endereço de entrega
            </div>
            <div class="co-panel-body">

                @if($addresses->isNotEmpty())
                    @foreach($addresses as $address)
                    <label class="address-option">
                        <input type="radio" name="endereco" value="{{ $address->logradouro }}, {{ $address->numero }}{{ $address->complemento ? ', '.$address->complemento : '' }} — {{ $address->bairro }}, {{ $address->cidade }}/{{ $address->estado }} — CEP {{ $address->cep }}"
                            {{ $address->principal ? 'checked' : '' }}>
                        <div>
                            <div class="address-option-label">
                                {{ $address->apelido ?? 'Endereço' }}
                                @if($address->principal)
                                    <span class="ec-badge ec-badge-info" style="font-size:0.7rem;">Principal</span>
                                @endif
                            </div>
                            <div class="address-option-text">
                                {{ $address->logradouro }}, {{ $address->numero }}
                                @if($address->complemento) — {{ $address->complemento }} @endif
                                <br>{{ $address->bairro }}, {{ $address->cidade }}/{{ $address->estado }}
                                <br>CEP: {{ $address->cep }}
                            </div>
                        </div>
                    </label>
                    @endforeach

                    <div style="margin-top:12px;">
                        <label style="font-size:0.8rem;font-weight:600;display:flex;align-items:center;gap:6px;cursor:pointer;">
                            <input type="radio" name="endereco" value="outro" id="outroEndereco">
                            Usar outro endereço
                        </label>
                    </div>
                @else
                    <input type="hidden" name="endereco" id="enderecoHidden">
                @endif

                <div id="novoEnderecoForm" style="{{ $addresses->isEmpty() ? '' : 'display:none;' }} margin-top:12px;">
                    <div class="co-row">
                        <div>
                            <label class="co-label">CEP</label>
                            <input type="text" class="co-input" id="cep" placeholder="00000-000" maxlength="9">
                        </div>
                        <div style="flex:2;">
                            <label class="co-label">Logradouro</label>
                            <input type="text" class="co-input" id="logradouro" placeholder="Rua, Avenida...">
                        </div>
                    </div>
                    <div class="co-row">
                        <div style="flex:0 0 100px;">
                            <label class="co-label">Número</label>
                            <input type="text" class="co-input" id="numero" placeholder="123">
                        </div>
                        <div>
                            <label class="co-label">Complemento</label>
                            <input type="text" class="co-input" id="complemento" placeholder="Apto, Bloco...">
                        </div>
                        <div>
                            <label class="co-label">Bairro</label>
                            <input type="text" class="co-input" id="bairro" placeholder="Bairro">
                        </div>
                    </div>
                    <div class="co-row">
                        <div style="flex:2;">
                            <label class="co-label">Cidade</label>
                            <input type="text" class="co-input" id="cidade" placeholder="Cidade">
                        </div>
                        <div style="flex:0 0 80px;">
                            <label class="co-label">Estado</label>
                            <input type="text" class="co-input" id="estado" placeholder="UF" maxlength="2">
                        </div>
                    </div>
                </div>

                @error('endereco')
                    <div style="color:#cc0000;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ENTREGA --}}
        <div class="co-panel">
            <div class="co-panel-title">
                <i class="bi bi-truck"></i> Entrega
                @if($freteGratis)
                    <span class="ec-badge ec-badge-success" style="margin-left:8px;">Frete grátis disponível!</span>
                @endif
            </div>
            <div class="co-panel-body">
                @foreach($deliveryOptions as $opt)
                @php $data = now()->addWeekdays($opt['days'])->format('d/m/Y'); @endphp
                <label class="delivery-option">
                    <input type="radio" name="dias_entrega" value="{{ $opt['days'] }}"
                           data-frete="{{ $opt['frete'] }}" {{ $loop->first ? 'checked' : '' }}>
                    <span class="delivery-option-label">{{ $opt['label'] }}</span>
                    <span class="delivery-option-date">
                        <i class="bi bi-calendar3"></i> {{ $data }}
                        &nbsp;·&nbsp;
                        @if($opt['frete'] == 0)
                            <span style="color:#067D62;font-weight:700;">Grátis</span>
                        @else
                            R$ {{ number_format($opt['frete'], 2, ',', '.') }}
                        @endif
                    </span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- PAGAMENTO --}}
        <div class="co-panel">
            <div class="co-panel-title">
                <i class="bi bi-credit-card"></i> Dados de pagamento
            </div>
            <div class="co-panel-body">

                {{-- Hidden fields — sempre submetidos --}}
                <input type="hidden" name="cartao_nome"     id="cartaoNomeHidden">
                <input type="hidden" name="cartao_numero"   id="cartaoNumeroHidden">
                <input type="hidden" name="cartao_validade" id="cartaoValidadeHidden">
                <input type="hidden" name="cartao_bandeira" id="cartaoBandeiraHidden" value="outro">

                @if($paymentMethods->isNotEmpty())

                    {{-- Cartões salvos --}}
                    @foreach($paymentMethods as $pm)
                    <label class="payment-option">
                        <input type="radio" name="payment_choice" value="saved"
                               data-titular="{{ $pm->titular }}"
                               data-numero="0000 0000 0000 {{ $pm->ultimos_digitos }}"
                               data-masked="•••• •••• •••• {{ $pm->ultimos_digitos }}"
                               data-validade="{{ $pm->validade }}"
                               data-bandeira="{{ $pm->bandeira }}"
                               {{ $pm->principal ? 'checked' : '' }}>
                        <div>
                            <div class="payment-option-label">
                                {{ $pm->apelido }}
                                @if($pm->principal)
                                    <span class="ec-badge ec-badge-info" style="font-size:0.7rem;">Principal</span>
                                @endif
                            </div>
                            <div class="payment-option-text">
                                {{ strtoupper($pm->bandeira) }} · •••• •••• •••• {{ $pm->ultimos_digitos }}
                                &nbsp;·&nbsp; {{ $pm->titular }}
                            </div>
                        </div>
                    </label>
                    @endforeach

                    <label class="payment-option" style="margin-top:4px;">
                        <input type="radio" name="payment_choice" value="novo">
                        <div>
                            <div class="payment-option-label">Usar outro cartão</div>
                        </div>
                    </label>

                @endif

                {{-- Preview visual --}}
                <div class="card-preview" style="margin-top:12px;">
                    <div class="card-preview-number" id="previewNumero">•••• •••• •••• ••••</div>
                    <div class="card-preview-row">
                        <div>
                            <div>TITULAR</div>
                            <div class="card-preview-val" id="previewNome">NOME DO TITULAR</div>
                        </div>
                        <div style="text-align:right;">
                            <div>VALIDADE</div>
                            <div class="card-preview-val" id="previewValidade">MM/AA</div>
                        </div>
                    </div>
                </div>

                {{-- Formulário manual — visível se não há cartões salvos ou "outro cartão" selecionado --}}
                <div id="cartaoManualForm" style="{{ $paymentMethods->isNotEmpty() ? 'display:none;' : '' }}">
                    <label class="co-label">Número do cartão</label>
                    <input type="text" class="co-input" id="cartaoNumeroInput"
                           placeholder="0000 0000 0000 0000" maxlength="19">
                    @error('cartao_numero')
                        <div style="color:#cc0000;font-size:0.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div>
                    @enderror

                    <label class="co-label">Nome do titular</label>
                    <input type="text" class="co-input" id="cartaoNomeInput"
                           placeholder="Como está no cartão">
                    @error('cartao_nome')
                        <div style="color:#cc0000;font-size:0.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div>
                    @enderror

                    <div class="co-row">
                        <div>
                            <label class="co-label">Validade</label>
                            <input type="text" class="co-input" id="cartaoValidadeInput"
                                   placeholder="MM/AA" maxlength="5">
                            @error('cartao_validade')
                                <div style="color:#cc0000;font-size:0.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="co-label">CVV</label>
                            <input type="text" name="cartao_cvv" class="co-input" id="cartaoCvvInput"
                                   placeholder="123" maxlength="4">
                            @error('cartao_cvv')
                                <div style="color:#cc0000;font-size:0.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- CVV para cartão salvo --}}
                @if($paymentMethods->isNotEmpty())
                <div id="cartaoSalvoCvv">
                    <label class="co-label" style="margin-top:4px;">CVV do cartão selecionado</label>
                    <input type="text" name="cartao_cvv" class="co-input" id="cartaoCvvSalvo"
                           placeholder="123" maxlength="4" style="max-width:120px;">
                    @error('cartao_cvv')
                        <div style="color:#cc0000;font-size:0.8rem;margin-top:-8px;margin-bottom:8px;">{{ $message }}</div>
                    @enderror
                </div>
                @endif

            </div>
        </div>

    </div>

    {{-- RESUMO DO PEDIDO --}}
    <div>
        <div class="co-panel">
            <div class="co-panel-title">
                <i class="bi bi-receipt"></i> Resumo do pedido
            </div>
            <div class="co-panel-body">

                @foreach($order->items as $item)
                <div class="summary-item">
                    <span class="summary-item-name">
                        {{ $item->product?->nome ?? 'Produto' }}
                        <span style="color:#888;"> × {{ $item->quantidade }}</span>
                    </span>
                    <span>R$ {{ number_format($item->preco * $item->quantidade, 2, ',', '.') }}</span>
                </div>
                @endforeach

                <div class="summary-item" style="margin-top:8px;">
                    <span class="summary-item-name" style="color:#555;">Subtotal</span>
                    <span>R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                </div>

                <div class="summary-item">
                    <span class="summary-item-name" style="color:#555;">Frete</span>
                    <span id="resumoFrete">
                        @if($deliveryOptions[0]['frete'] == 0)
                            <span style="color:#067D62;font-weight:600;">Grátis</span>
                        @else
                            R$ {{ number_format($deliveryOptions[0]['frete'], 2, ',', '.') }}
                        @endif
                    </span>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span id="resumoTotal">R$ {{ number_format($order->total + $deliveryOptions[0]['frete'], 2, ',', '.') }}</span>
                </div>

                <button type="submit" class="btn-ec-primary" style="width:100%;justify-content:center;margin-top:16px;padding:10px;">
                    <i class="bi bi-lock-fill"></i> Confirmar pedido
                </button>

            </div>
        </div>
    </div>

</div>
</form>

@push('scripts')
<script>
(function () {
    // Atualiza frete e total ao trocar opção de entrega
    const subtotal = {{ $order->total }};
    const freteInput  = document.getElementById('freteValorInput');
    const resumoFrete = document.getElementById('resumoFrete');
    const resumoTotal = document.getElementById('resumoTotal');

    function fmt(v) {
        return 'R$ ' + v.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.querySelectorAll('input[name="dias_entrega"]').forEach(function (r) {
        r.addEventListener('change', function () {
            const frete = parseFloat(this.dataset.frete) || 0;
            freteInput.value = frete;
            resumoFrete.innerHTML = frete === 0
                ? '<span style="color:#067D62;font-weight:600;">Grátis</span>'
                : fmt(frete);
            resumoTotal.textContent = fmt(subtotal + frete);
        });
    });

    // Mostrar/ocultar form de novo endereço
    document.querySelectorAll('input[name="endereco"]').forEach(function (r) {
        r.addEventListener('change', function () {
            const form = document.getElementById('novoEnderecoForm');
            if (form) form.style.display = this.value === 'outro' ? 'block' : 'none';
        });
    });

    // Montar endereço manual no hidden se não houver endereços salvos
    const enderecoHidden = document.getElementById('enderecoHidden');
    if (enderecoHidden) {
        ['cep','logradouro','numero','complemento','bairro','cidade','estado'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', function () {
                const l = document.getElementById('logradouro').value;
                const n = document.getElementById('numero').value;
                const c = document.getElementById('complemento').value;
                const b = document.getElementById('bairro').value;
                const ci = document.getElementById('cidade').value;
                const e = document.getElementById('estado').value;
                const cep = document.getElementById('cep').value;
                enderecoHidden.value = l + ', ' + n + (c ? ', ' + c : '') + ' — ' + b + ', ' + ci + '/' + e + ' — CEP ' + cep;
            });
        });
    }

    // ── Lógica de pagamento ──────────────────────────────────────
    const nomeHidden     = document.getElementById('cartaoNomeHidden');
    const numHidden      = document.getElementById('cartaoNumeroHidden');
    const valHidden      = document.getElementById('cartaoValidadeHidden');
    const manualForm     = document.getElementById('cartaoManualForm');
    const salvoCvvWrap   = document.getElementById('cartaoSalvoCvv');
    const previewNumero  = document.getElementById('previewNumero');
    const previewNome    = document.getElementById('previewNome');
    const previewValidade= document.getElementById('previewValidade');

    function updatePreview(numero, nome, validade) {
        previewNumero.textContent  = numero  || '•••• •••• •••• ••••';
        previewNome.textContent    = (nome   || 'NOME DO TITULAR').toUpperCase();
        previewValidade.textContent= validade || 'MM/AA';
    }

    const bandeiraHidden = document.getElementById('cartaoBandeiraHidden');

    function applySavedCard(radio) {
        const d = radio.dataset;
        nomeHidden.value    = d.titular;
        numHidden.value     = d.numero;
        valHidden.value     = d.validade;
        if (bandeiraHidden) bandeiraHidden.value = d.bandeira || 'outro';
        updatePreview(d.masked, d.titular, d.validade);
        if (manualForm)   manualForm.style.display   = 'none';
        if (salvoCvvWrap) salvoCvvWrap.style.display = 'block';
    }

    function detectBandeira(num) {
        const n = num.replace(/\D/g, '');
        if (/^4/.test(n))           return 'visa';
        if (/^5[1-5]/.test(n))      return 'mastercard';
        if (/^3[47]/.test(n))       return 'amex';
        if (/^(4011|431274|438935|451416|457393|4576|457631|457632|504175|627780|636297|636368|6504|6505|6507|6509|6516|6550)/.test(n)) return 'elo';
        return 'outro';
    }

    function applyManualCard() {
        if (manualForm)   manualForm.style.display   = 'block';
        if (salvoCvvWrap) salvoCvvWrap.style.display = 'none';
        if (bandeiraHidden) bandeiraHidden.value = 'outro';
        updatePreview(null, null, null);
    }

    const cvvManual = document.getElementById('cartaoCvvInput');
    const cvvSalvo  = document.getElementById('cartaoCvvSalvo');

    function syncCvvDisabled(isSaved) {
        if (cvvManual) cvvManual.disabled = isSaved;
        if (cvvSalvo)  cvvSalvo.disabled  = !isSaved;
    }

    // Inicializar com o cartão marcado (se houver)
    const checkedPayment = document.querySelector('input[name="payment_choice"]:checked');
    if (checkedPayment) {
        if (checkedPayment.value === 'saved') { applySavedCard(checkedPayment); syncCvvDisabled(true); }
        else { applyManualCard(); syncCvvDisabled(false); }
    } else {
        syncCvvDisabled(false);
    }

    document.querySelectorAll('input[name="payment_choice"]').forEach(function (r) {
        r.addEventListener('change', function () {
            if (this.value === 'saved') { applySavedCard(this); syncCvvDisabled(true); }
            else { applyManualCard(); syncCvvDisabled(false); }
        });
    });

    // Inputs do formulário manual → preview + hiddens
    const numInput = document.getElementById('cartaoNumeroInput');
    const nomInput = document.getElementById('cartaoNomeInput');
    const valInput = document.getElementById('cartaoValidadeInput');

    if (numInput) {
        numInput.addEventListener('input', function () {
            const raw = this.value.replace(/\D/g, '').substring(0, 16);
            this.value = raw.replace(/(.{4})/g, '$1 ').trim();
            numHidden.value = this.value;
            if (bandeiraHidden) bandeiraHidden.value = detectBandeira(raw);
            const masked = raw.padEnd(16, '•').replace(/(.{4})/g, '$1 ').trim();
            previewNumero.textContent = masked;
        });
    }

    if (nomInput) {
        nomInput.addEventListener('input', function () {
            nomeHidden.value = this.value;
            previewNome.textContent = this.value.toUpperCase() || 'NOME DO TITULAR';
        });
    }

    if (valInput) {
        valInput.addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '');
            if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2,4);
            this.value = v;
            valHidden.value = this.value;
            previewValidade.textContent = this.value || 'MM/AA';
        });
    }
})();
</script>
@endpush

@endsection

@extends('layouts.app')
@section('title', 'Meu Perfil')

@push('styles')
<style>
    .profile-section {
        margin-bottom: 24px;
    }
    .section-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        border-bottom: 1px solid #ddd;
    }
    .section-heading h3 {
        font-size: .95rem;
        font-weight: bold;
        margin: 0;
        color: #333;
    }
    .section-heading p {
        font-size: .78rem;
        color: #666;
        margin: 0;
    }
    .section-body { padding: 20px; }

    .address-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .address-card {
        border: 1px solid #ddd;
        padding: 14px;
        background: #fafafa;
    }
    .address-card.principal {
        border-color: #0066cc;
        background: #f0f7ff;
    }
    .address-apelido {
        font-weight: bold;
        font-size: .875rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .address-text {
        font-size: .8rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 10px;
    }
    .address-actions { display: flex; gap: 8px; }

    .add-form-wrap { display: none; }
    .add-form-wrap.open { display: block; }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 14px;
        margin-bottom: 16px;
    }
    .card-item {
        border: 1px solid #ddd;
        padding: 14px;
        background: #fafafa;
    }
    .card-item.principal {
        border-color: #0066cc;
        background: #f0f7ff;
    }
    .card-apelido {
        font-weight: bold;
        font-size: .875rem;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-text {
        font-size: .8rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 10px;
        font-family: monospace;
    }
    .card-actions { display: flex; gap: 8px; }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .form-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 600px) {
        .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
    }

    .ec-label {
        display: block;
        font-size: .875rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
</style>
@endpush

@section('content')

<div style="font-size:.8rem;color:#666;margin-bottom:8px;">
    <a href="{{ route('home') }}" style="color:#0066cc;text-decoration:none;">Página inicial</a>
    &rsaquo; Meu Perfil
</div>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="ec-page-title">Meu Perfil</h1>
    @if(Auth::user()->vendedor)
        <span class="ec-badge ec-badge-warning">
            <i class="bi bi-shop"></i> Conta Vendedor
        </span>
    @else
        <span class="ec-badge ec-badge-info">
            <i class="bi bi-person"></i> Comprador
        </span>
    @endif
</div>

{{-- SEÇÃO 1 — DADOS PESSOAIS --}}
<div class="profile-section ec-card">
    <div class="section-heading">
        <i class="bi bi-person" style="font-size:1.2rem;color:#555;"></i>
        <div>
            <h3>Dados pessoais</h3>
            <p>Nome e e-mail da sua conta</p>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('profile.dados') }}">
            @csrf
            <div class="form-grid-2" style="max-width:600px;">
                <div>
                    <label class="ec-label">Nome completo</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="ec-form-control @error('name') is-invalid @enderror"
                        required
                    >
                    @error('name')
                        <span style="font-size:.78rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="ec-label">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="ec-form-control @error('email') is-invalid @enderror"
                        required
                    >
                    @error('email')
                        <span style="font-size:.78rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                    @enderror
                </div>
                @if($user->vendedor && $user->cnpj)
                <div>
                    <label class="ec-label">CNPJ</label>
                    <input
                        type="text"
                        value="{{ preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $user->cnpj) }}"
                        class="ec-form-control"
                        disabled
                        style="background:#f5f5f5;color:#888;"
                    >
                </div>
                @endif
            </div>
            <div style="margin-top:18px;">
                <button type="submit" class="btn-ec-primary" style="width:auto;">
                    <i class="bi bi-check-lg"></i> Salvar dados
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SEÇÃO 2 — ENDEREÇOS --}}
<div class="profile-section ec-card">
    <div class="section-heading">
        <i class="bi bi-geo-alt" style="font-size:1.2rem;color:#555;"></i>
        <div>
            <h3>Meus endereços</h3>
            <p>Endereços de entrega cadastrados</p>
        </div>
    </div>
    <div class="section-body">

        @if($addresses->isEmpty())
            <div style="text-align:center;padding:24px 0;color:#888;">
                <i class="bi bi-geo-alt" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                <p style="margin-bottom:0;font-size:.875rem;">Nenhum endereço cadastrado ainda.</p>
            </div>
        @else
            <div class="address-grid">
                @foreach($addresses as $address)
                <div class="address-card {{ $address->principal ? 'principal' : '' }}">
                    <div class="address-apelido">
                        <i class="bi bi-house"></i>
                        {{ $address->apelido }}
                        @if($address->principal)
                            <span class="ec-badge ec-badge-info" style="font-size:.65rem;padding:2px 8px;">Principal</span>
                        @endif
                    </div>
                    <div class="address-text">
                        {{ $address->logradouro }}, {{ $address->numero }}
                        @if($address->complemento) — {{ $address->complemento }}@endif
                        <br>{{ $address->bairro }} · {{ $address->cidade }}/{{ $address->estado }}
                        <br>CEP: {{ $address->cep }}
                    </div>
                    <div class="address-actions">
                        @if(!$address->principal)
                            <form action="{{ route('profile.enderecos.principal', $address) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-ec-ghost" style="font-size:.75rem;padding:5px 10px;">
                                    Definir principal
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('profile.enderecos.destroy', $address) }}" method="POST"
                              onsubmit="return confirm('Remover este endereço?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-ec-danger" style="font-size:.75rem;padding:5px 10px;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <button type="button" id="toggleAddressForm" class="btn-ec-outline" onclick="toggleAddressForm()">
            <i class="bi bi-plus-lg"></i> Adicionar endereço
        </button>

        <div class="add-form-wrap" id="addressFormWrap" style="margin-top:18px;">
            <div style="border-top:1px solid #ddd;padding-top:18px;">
                <p style="font-size:.875rem;font-weight:bold;margin-bottom:14px;">Novo endereço</p>
                <form method="POST" action="{{ route('profile.enderecos.store') }}">
                    @csrf

                    <div style="margin-bottom:12px;max-width:220px;">
                        <label class="ec-label">Apelido</label>
                        <input type="text" name="apelido" value="{{ old('apelido', 'Casa') }}"
                               class="ec-form-control @error('apelido') is-invalid @enderror"
                               placeholder="Casa, Trabalho...">
                        @error('apelido') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-grid-3" style="margin-bottom:12px;">
                        <div>
                            <label class="ec-label">CEP</label>
                            <input type="text" name="cep" id="cepInput" value="{{ old('cep') }}"
                                   class="ec-form-control @error('cep') is-invalid @enderror"
                                   placeholder="00000-000" maxlength="9" inputmode="numeric">
                            @error('cep') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div style="grid-column: span 2;">
                            <label class="ec-label">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" value="{{ old('logradouro') }}"
                                   class="ec-form-control @error('logradouro') is-invalid @enderror"
                                   placeholder="Rua, Avenida...">
                            @error('logradouro') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-grid-3" style="margin-bottom:12px;">
                        <div>
                            <label class="ec-label">Número</label>
                            <input type="text" name="numero" value="{{ old('numero') }}"
                                   class="ec-form-control @error('numero') is-invalid @enderror"
                                   placeholder="123">
                            @error('numero') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div style="grid-column: span 2;">
                            <label class="ec-label">Complemento <span style="font-weight:normal;color:#888;">(opcional)</span></label>
                            <input type="text" name="complemento" value="{{ old('complemento') }}"
                                   class="ec-form-control"
                                   placeholder="Apto, Bloco...">
                        </div>
                    </div>

                    <div class="form-grid-3" style="margin-bottom:18px;">
                        <div>
                            <label class="ec-label">Bairro</label>
                            <input type="text" name="bairro" id="bairro" value="{{ old('bairro') }}"
                                   class="ec-form-control @error('bairro') is-invalid @enderror">
                            @error('bairro') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="ec-label">Cidade</label>
                            <input type="text" name="cidade" id="cidade" value="{{ old('cidade') }}"
                                   class="ec-form-control @error('cidade') is-invalid @enderror">
                            @error('cidade') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="ec-label">Estado (UF)</label>
                            <input type="text" name="estado" id="estado" value="{{ old('estado') }}"
                                   class="ec-form-control @error('estado') is-invalid @enderror"
                                   maxlength="2" placeholder="SP" style="text-transform:uppercase;">
                            @error('estado') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button type="submit" class="btn-ec-primary" style="width:auto;">
                            <i class="bi bi-plus-lg"></i> Salvar endereço
                        </button>
                        <button type="button" class="btn-ec-ghost" onclick="toggleAddressForm()">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($errors->hasAny(['apelido','cep','logradouro','numero','bairro','cidade','estado']))
            <script>document.addEventListener('DOMContentLoaded', function(){ openAddressForm(); });</script>
        @endif
    </div>
</div>

{{-- SEÇÃO 3 — FORMAS DE PAGAMENTO --}}
<div class="profile-section ec-card">
    <div class="section-heading">
        <i class="bi bi-credit-card" style="font-size:1.2rem;color:#555;"></i>
        <div>
            <h3>Formas de pagamento</h3>
            <p>Cartões salvos para compras</p>
        </div>
    </div>
    <div class="section-body">

        @if($paymentMethods->isEmpty())
            <div style="text-align:center;padding:24px 0;color:#888;">
                <i class="bi bi-credit-card" style="font-size:2rem;display:block;margin-bottom:8px;"></i>
                <p style="margin-bottom:0;font-size:.875rem;">Nenhum cartão cadastrado ainda.</p>
            </div>
        @else
            <div class="card-grid">
                @foreach($paymentMethods as $pm)
                <div class="card-item {{ $pm->principal ? 'principal' : '' }}">
                    <div class="card-apelido">
                        <i class="bi bi-credit-card-2-front"></i>
                        {{ $pm->apelido }}
                        @if($pm->principal)
                            <span class="ec-badge ec-badge-info" style="font-size:.65rem;padding:2px 8px;">Principal</span>
                        @endif
                    </div>
                    <div class="card-text">
                        {{ strtoupper($pm->bandeira) }} · •••• •••• •••• {{ $pm->ultimos_digitos }}<br>
                        {{ $pm->titular }}<br>
                        Validade: {{ $pm->validade }}
                    </div>
                    <div class="card-actions">
                        @if(!$pm->principal)
                            <form action="{{ route('profile.cartoes.principal', $pm) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-ec-ghost" style="font-size:.75rem;padding:5px 10px;">
                                    Definir principal
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('profile.cartoes.destroy', $pm) }}" method="POST"
                              onsubmit="return confirm('Remover este cartão?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-ec-danger" style="font-size:.75rem;padding:5px 10px;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        <button type="button" id="toggleCardForm" class="btn-ec-outline" onclick="toggleCardForm()">
            <i class="bi bi-plus-lg"></i> Adicionar cartão
        </button>

        <div class="add-form-wrap" id="cardFormWrap" style="margin-top:18px;">
            <div style="border-top:1px solid #ddd;padding-top:18px;">
                <p style="font-size:.875rem;font-weight:bold;margin-bottom:14px;">Novo cartão</p>
                <form method="POST" action="{{ route('profile.cartoes.store') }}">
                    @csrf

                    <div class="form-grid-2" style="margin-bottom:12px;max-width:480px;">
                        <div>
                            <label class="ec-label">Apelido</label>
                            <input type="text" name="apelido" value="{{ old('apelido', 'Meu Cartão') }}"
                                   class="ec-form-control @error('apelido') is-invalid @enderror"
                                   placeholder="Meu Cartão, Débito...">
                            @error('apelido') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="ec-label">Bandeira</label>
                            <select name="bandeira" class="ec-form-control @error('bandeira') is-invalid @enderror">
                                <option value="visa"        {{ old('bandeira') === 'visa'        ? 'selected' : '' }}>Visa</option>
                                <option value="mastercard"  {{ old('bandeira') === 'mastercard'  ? 'selected' : '' }}>Mastercard</option>
                                <option value="elo"         {{ old('bandeira') === 'elo'         ? 'selected' : '' }}>Elo</option>
                                <option value="amex"        {{ old('bandeira') === 'amex'        ? 'selected' : '' }}>Amex</option>
                                <option value="outro"       {{ old('bandeira') === 'outro'       ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('bandeira') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="margin-bottom:12px;max-width:480px;">
                        <label class="ec-label">Nome do titular</label>
                        <input type="text" name="titular" value="{{ old('titular') }}"
                               class="ec-form-control @error('titular') is-invalid @enderror"
                               placeholder="Como está no cartão" style="text-transform:uppercase;">
                        @error('titular') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-grid-2" style="margin-bottom:18px;max-width:480px;">
                        <div>
                            <label class="ec-label">Número do cartão</label>
                            <input type="text" name="numero_cartao" id="profileCardNumero"
                                   value="{{ old('numero_cartao') }}"
                                   class="ec-form-control @error('numero_cartao') is-invalid @enderror"
                                   placeholder="0000 0000 0000 0000" maxlength="19" inputmode="numeric">
                            @error('numero_cartao') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="ec-label">Validade</label>
                            <input type="text" name="validade" id="profileCardValidade"
                                   value="{{ old('validade') }}"
                                   class="ec-form-control @error('validade') is-invalid @enderror"
                                   placeholder="MM/AA" maxlength="5" inputmode="numeric">
                            @error('validade') <span style="font-size:.75rem;color:#cc0000;">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button type="submit" class="btn-ec-primary" style="width:auto;">
                            <i class="bi bi-plus-lg"></i> Salvar cartão
                        </button>
                        <button type="button" class="btn-ec-ghost" onclick="toggleCardForm()">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($errors->hasAny(['apelido','bandeira','titular','numero_cartao','validade']))
            <script>document.addEventListener('DOMContentLoaded', function(){ openCardForm(); });</script>
        @endif
    </div>
</div>

{{-- SEÇÃO 4 — SEGURANÇA --}}
<div class="profile-section ec-card">
    <div class="section-heading">
        <i class="bi bi-shield-lock" style="font-size:1.2rem;color:#555;"></i>
        <div>
            <h3>Segurança</h3>
            <p>Altere sua senha de acesso</p>
        </div>
    </div>
    <div class="section-body">
        <form method="POST" action="{{ route('profile.senha') }}" style="max-width:400px;">
            @csrf
            <div style="margin-bottom:12px;">
                <label class="ec-label">Senha atual</label>
                <input
                    type="password"
                    name="current_password"
                    class="ec-form-control @error('current_password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                >
                @error('current_password')
                    <span style="font-size:.78rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>
            <div style="margin-bottom:12px;">
                <label class="ec-label">Nova senha</label>
                <input
                    type="password"
                    name="password"
                    class="ec-form-control @error('password') is-invalid @enderror"
                    placeholder="Mínimo 8 caracteres"
                    autocomplete="new-password"
                >
                @error('password')
                    <span style="font-size:.78rem;color:#cc0000;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>
            <div style="margin-bottom:18px;">
                <label class="ec-label">Confirmar nova senha</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="ec-form-control"
                    placeholder="Repita a nova senha"
                    autocomplete="new-password"
                >
            </div>
            <button type="submit" class="btn-ec-primary" style="width:auto;">
                <i class="bi bi-lock"></i> Alterar senha
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleAddressForm() {
    const wrap = document.getElementById('addressFormWrap');
    const btn  = document.getElementById('toggleAddressForm');
    const open = wrap.classList.toggle('open');
    btn.innerHTML = open
        ? '<i class="bi bi-x-lg"></i> Cancelar'
        : '<i class="bi bi-plus-lg"></i> Adicionar endereço';
}
function openAddressForm() {
    const wrap = document.getElementById('addressFormWrap');
    const btn  = document.getElementById('toggleAddressForm');
    wrap.classList.add('open');
    btn.innerHTML = '<i class="bi bi-x-lg"></i> Cancelar';
}

function toggleCardForm() {
    const wrap = document.getElementById('cardFormWrap');
    const btn  = document.getElementById('toggleCardForm');
    const open = wrap.classList.toggle('open');
    btn.innerHTML = open
        ? '<i class="bi bi-x-lg"></i> Cancelar'
        : '<i class="bi bi-plus-lg"></i> Adicionar cartão';
}
function openCardForm() {
    const wrap = document.getElementById('cardFormWrap');
    const btn  = document.getElementById('toggleCardForm');
    wrap.classList.add('open');
    btn.innerHTML = '<i class="bi bi-x-lg"></i> Cancelar';
}

document.getElementById('profileCardNumero')?.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 16);
    this.value = v.replace(/(.{4})/g, '$1 ').trim();
});
document.getElementById('profileCardValidade')?.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '');
    if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2,4);
    this.value = v;
});

document.getElementById('cepInput')?.addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(r => r.json())
        .then(data => {
            if (data.erro) return;
            document.getElementById('logradouro').value = data.logradouro || '';
            document.getElementById('bairro').value     = data.bairro     || '';
            document.getElementById('cidade').value     = data.localidade  || '';
            document.getElementById('estado').value     = data.uf          || '';
        })
        .catch(() => {});
});

document.getElementById('cepInput')?.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 8);
    if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
    this.value = v;
});
</script>
@endpush

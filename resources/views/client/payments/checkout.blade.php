@extends('layouts.app')
@section('title','Paiement')
@section('content')
<style>
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;}
.back-link:hover{color:#f59e0b;}
.checkout-grid{display:grid;grid-template-columns:1fr 380px;gap:24px;max-width:900px;}
.summary-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;}
.summary-title{font-family:'Syne',sans-serif;font-size:16px;font-weight:600;color:#fff;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #2a2d3a;}
.summary-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #1a1c2a;font-size:14px;}
.summary-row:last-child{border-bottom:none;}
.summary-label{color:#9496a8;}
.summary-value{color:#e8e9f0;font-weight:500;}
.total-row{background:#0f1117;border-radius:8px;padding:14px 16px;margin-top:16px;display:flex;justify-content:space-between;align-items:center;}
.total-label{font-size:14px;color:#fff;font-weight:600;}
.total-value{font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#f59e0b;}

.payment-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;}
.payment-title{font-family:'Syne',sans-serif;font-size:16px;font-weight:600;color:#fff;margin-bottom:20px;}

/* Méthodes de paiement */
.method-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;}
.method-btn{border:1px solid #2a2d3a;border-radius:10px;padding:14px;text-align:center;cursor:pointer;transition:.2s;background:#0f1117;}
.method-btn:hover{border-color:#f59e0b;}
.method-btn.selected{border-color:#f59e0b;background:#1e1a0a;}
.method-btn input{display:none;}
.method-icon{font-size:22px;margin-bottom:6px;}
.method-name{font-size:12px;font-weight:600;color:#e8e9f0;}
.method-sub{font-size:10px;color:#555870;margin-top:2px;}

/* Champ téléphone */
.phone-field{margin-bottom:16px;display:none;}
.phone-field.show{display:block;}
label{font-size:12px;color:#9496a8;display:block;margin-bottom:6px;font-weight:500;}
input[type=tel],input[type=text]{width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
input:focus{border-color:#f59e0b;}

/* Boutons */
.btn-pay{width:100%;padding:14px;background:#f59e0b;color:#0f1117;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;margin-top:8px;}
.btn-pay:hover{background:#e08d00;}
.btn-manual{width:100%;padding:12px;background:transparent;color:#9496a8;font-size:13px;border:1px solid #2a2d3a;border-radius:8px;cursor:pointer;transition:.2s;margin-top:10px;font-family:'DM Sans',sans-serif;}
.btn-manual:hover{color:#fff;border-color:#555870;}

/* Sécurité badge */
.security-badge{display:flex;align-items:center;gap:8px;padding:12px 14px;background:#0d2e1a;border-radius:8px;margin-top:16px;}
.security-badge svg{width:16px;height:16px;color:#4ade80;flex-shrink:0;}
.security-badge span{font-size:11px;color:#4ade80;}

/* NotchPay badge */
.notchpay-badge{text-align:center;margin-top:12px;}
.notchpay-badge span{font-size:11px;color:#555870;}
.notchpay-badge strong{color:#f59e0b;}

.alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;}
.alert-error{background:#2e0d0d;border:1px solid #7f1d1d;color:#f87171;}

@media(max-width:800px){.checkout-grid{grid-template-columns:1fr;}.method-grid{grid-template-columns:1fr 1fr;}}
</style>

<a href="{{ route('client.rentals') }}" class="back-link">← Retour aux locations</a>
<div class="page-header"><h1>Paiement de location</h1><p>Finalisez votre paiement en toute sécurité</p></div>

@if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif

<div class="checkout-grid">

    {{-- Résumé --}}
    <div class="summary-card">
        <div class="summary-title">Récapitulatif de la location</div>

        {{-- Image véhicule --}}
        @if($rental->vehicle->image)
        <img src="{{ asset('storage/'.$rental->vehicle->image) }}"
             style="width:100%;height:160px;object-fit:cover;border-radius:10px;margin-bottom:20px;border:1px solid #2a2d3a;"
             alt="{{ $rental->vehicle->brand }}">
        @else
        <div style="width:100%;height:120px;background:#0f1117;border-radius:10px;margin-bottom:20px;display:flex;align-items:center;justify-content:center;border:1px solid #2a2d3a;">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#3a3d50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        @endif

        <div class="summary-row">
            <span class="summary-label">Véhicule</span>
            <span class="summary-value">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Plaque</span>
            <span class="summary-value">{{ $rental->vehicle->plate }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Date début</span>
            <span class="summary-value">{{ $rental->start_date->format('d/m/Y') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Date fin</span>
            <span class="summary-value">{{ $rental->end_date->format('d/m/Y') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Durée</span>
            <span class="summary-value">{{ $rental->total_days }} jour(s)</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Prix/jour</span>
            <span class="summary-value">{{ number_format($rental->vehicle->price_per_day,0,',',' ') }} FCFA</span>
        </div>
        <div class="total-row">
            <span class="total-label">TOTAL À PAYER</span>
            <span class="total-value">{{ number_format($rental->total_price,0,',',' ') }} FCFA</span>
        </div>

        @if($rental->contract)
        <div style="margin-top:12px;text-align:center;">
            <a href="{{ route('client.contracts.show',$rental->contract) }}"
               style="font-size:12px;color:#f59e0b;text-decoration:none;">
                Voir le contrat →
            </a>
        </div>
        @endif
    </div>

    {{-- Formulaire paiement --}}
    <div>
        <div class="payment-card">
            <div class="payment-title">Choisir une méthode de paiement</div>

            <form method="POST" action="{{ route('client.payment.initiate', $rental) }}" id="payForm">
                @csrf
                <input type="hidden" name="method" id="selectedMethod" value="">

                <div class="method-grid">
                    <label class="method-btn" onclick="selectMethod('mobile_money', this)">
                        <div class="method-icon">📱</div>
                        <div class="method-name">Mobile Money</div>
                        <div class="method-sub">MTN / Orange</div>
                    </label>
                    <label class="method-btn" onclick="selectMethod('card', this)">
                        <div class="method-icon">💳</div>
                        <div class="method-name">Carte bancaire</div>
                        <div class="method-sub">Visa / Mastercard</div>
                    </label>
                </div>

                <div class="phone-field" id="phoneField">
                    <label>Numéro Mobile Money</label>
                    <input type="tel" name="phone" placeholder="6XX XXX XXX"
                           value="{{ auth()->user()->phone }}">
                </div>

                <button type="submit" class="btn-pay" id="payBtn" disabled
                        style="opacity:.5;cursor:not-allowed;">
                    Payer via NotchPay →
                </button>

                <div class="security-badge">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Paiement sécurisé via NotchPay — SSL 256-bit</span>
                </div>

                <div class="notchpay-badge">
                    <span>Propulsé par <strong>NotchPay</strong></span>
                </div>
            </form>
        </div>

        {{-- Paiement manuel --}}
        <div class="payment-card" style="margin-top:16px;">
            <div style="font-size:13px;color:#9496a8;margin-bottom:16px;">
                Ou choisissez un paiement en agence :
            </div>
            <form method="POST" action="{{ route('client.payment.manual', $rental) }}">
                @csrf
                <select name="method" style="width:100%;padding:10px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:13px;font-family:'DM Sans',sans-serif;margin-bottom:10px;outline:none;">
                    <option value="cash">Espèces en agence</option>
                    <option value="transfer">Virement bancaire</option>
                </select>
                <button type="submit" class="btn-manual">
                    Demander un paiement manuel
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let selectedBtn = null;

function selectMethod(method, el) {
    if (selectedBtn) selectedBtn.classList.remove('selected');
    el.classList.add('selected');
    selectedBtn = el;
    document.getElementById('selectedMethod').value = method;

    const phoneField = document.getElementById('phoneField');
    phoneField.classList.toggle('show', method === 'mobile_money');

    const payBtn = document.getElementById('payBtn');
    payBtn.disabled = false;
    payBtn.style.opacity = '1';
    payBtn.style.cursor = 'pointer';
}
</script>
@endsection
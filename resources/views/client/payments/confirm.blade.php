@extends('layouts.app')
@section('title','Confirmation du paiement')
@section('content')
<style>
.confirm-wrap{max-width:500px;margin:0 auto;}
.confirm-card{background:#161820;border:1px solid #2a2d3a;border-radius:16px;padding:32px;text-align:center;}
.confirm-icon{width:64px;height:64px;border-radius:50%;background:#2e1f05;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;}
.confirm-icon svg{width:32px;height:32px;color:#fbbf24;}
.confirm-title{font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;margin-bottom:8px;}
.confirm-sub{font-size:13px;color:#9496a8;line-height:1.7;margin-bottom:20px;}
.amount-big{font-family:'Syne',sans-serif;font-size:36px;font-weight:700;color:#fff;margin-bottom:4px;}
.amount-sub{font-size:12px;color:#555870;margin-bottom:20px;}
.confirm-ref{background:#0f1117;border-radius:8px;padding:12px 16px;margin-bottom:20px;}
.confirm-ref span{font-size:11px;color:#555870;display:block;margin-bottom:4px;}
.confirm-ref strong{font-family:'Syne',sans-serif;font-size:13px;color:#f59e0b;word-break:break-all;}
.steps{text-align:left;margin-bottom:24px;background:#0f1117;border-radius:10px;padding:16px;}
.step{display:flex;align-items:flex-start;gap:12px;padding:8px 0;border-bottom:1px solid #1a1c2a;}
.step:last-child{border-bottom:none;}
.step-num{width:22px;height:22px;border-radius:50%;background:#f59e0b;color:#0f1117;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
.step-text{font-size:13px;color:#9496a8;line-height:1.5;}
.step-text strong{color:#e8e9f0;}
.btn-verify{width:100%;padding:13px;background:#f59e0b;color:#0f1117;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;text-decoration:none;display:block;margin-bottom:10px;transition:.2s;}
.btn-verify:hover{background:#e08d00;}
.btn-cancel{width:100%;padding:11px;background:transparent;border:1px solid #2a2d3a;border-radius:8px;color:#9496a8;font-size:13px;text-decoration:none;display:block;transition:.2s;}
.btn-cancel:hover{color:#fff;border-color:#555870;}
.alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;}
.alert-info{background:#071e38;border:1px solid #1e3a5f;color:#60a5fa;}
.alert-error{background:#2e0d0d;border:1px solid #7f1d1d;color:#f87171;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;}
.sim-badge{background:#1a1a2e;border:1px solid #3730a3;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:12px;color:#a78bfa;display:flex;align-items:center;gap:8px;}
.loader-wrap{display:none;text-align:center;padding:16px;}
.spinner{width:28px;height:28px;border:3px solid #2a2d3a;border-top-color:#f59e0b;border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 10px;}
@keyframes spin{to{transform:rotate(360deg);}}
</style>

<div class="confirm-wrap">

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    {{-- Badge mode simulation --}}
    @if(env('PAYMENT_SIMULATION'))
    <div class="sim-badge">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        Mode simulation activé — le paiement sera confirmé automatiquement
    </div>
    @endif

    <div class="confirm-card">
        <div class="confirm-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
        </div>

        <div class="confirm-title">Confirmez votre paiement</div>
        <div class="confirm-sub">
            @if(env('PAYMENT_SIMULATION'))
                Cliquez sur "Confirmer" pour simuler le paiement.
            @else
                Un message a été envoyé sur votre téléphone.<br>
                Suivez les instructions pour valider.
            @endif
        </div>

        <div class="amount-big">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
        <div class="amount-sub">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</div>

        <div class="confirm-ref">
            <span>Référence de transaction</span>
            <strong>{{ $reference }}</strong>
        </div>

        @if(!env('PAYMENT_SIMULATION'))
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">
                    Ouvrez <strong>MTN MoMo</strong> ou <strong>Orange Money</strong>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">
                    Entrez votre <strong>PIN</strong> pour autoriser
                    <strong>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</strong>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">
                    Cliquez <strong>"J'ai payé"</strong> ci-dessous
                </div>
            </div>
        </div>
        @endif

        {{-- Bouton vérification --}}
        <a href="{{ route('client.payment.verify', ['rental' => $rental->id, 'reference' => $reference]) }}"
           class="btn-verify"
           id="verifyBtn"
           onclick="showLoader(event)">
            @if(env('PAYMENT_SIMULATION'))
                ✓ Confirmer le paiement (simulation)
            @else
                ✓ J'ai effectué le paiement
            @endif
        </a>

        <div class="loader-wrap" id="loaderWrap">
            <div class="spinner"></div>
            <div style="font-size:13px;color:#9496a8;">
                @if(env('PAYMENT_SIMULATION'))
                    Simulation en cours...
                @else
                    Vérification en cours...
                @endif
            </div>
        </div>

        <a href="{{ route('client.payment.checkout', $rental) }}" class="btn-cancel">
            ← Annuler et changer de méthode
        </a>
    </div>
</div>

<script>
function showLoader(e) {
    e.preventDefault();
    const btn  = document.getElementById('verifyBtn');
    const loader = document.getElementById('loaderWrap');
    btn.style.display    = 'none';
    loader.style.display = 'block';
    // Redirige après 500ms pour laisser le loader apparaître
    setTimeout(() => {
        window.location.href = btn.href;
    }, 500);
}
</script>
@endsection
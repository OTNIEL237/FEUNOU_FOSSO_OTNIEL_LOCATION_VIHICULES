@extends('layouts.app')
@section('title',$contract->contract_number)
@section('content')
<style>
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;}
.back-link:hover{color:#f59e0b;}
.contract-wrapper{max-width:700px;}
.contract-doc{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
.contract-head{background:#0f1117;padding:32px;border-bottom:1px solid #2a2d3a;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;}
.contract-logo{font-family:'Syne',sans-serif;font-size:24px;font-weight:800;color:#fff;}
.contract-logo em{color:#f59e0b;font-style:normal;}
.contract-num{font-size:13px;color:#555870;margin-top:4px;}
.sp{padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;}
.contract-body{padding:32px;}
.section-title{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin-bottom:12px;}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:28px;}
.info-item{background:#0f1117;border-radius:8px;padding:12px 16px;}
.info-label{font-size:11px;color:#555870;margin-bottom:4px;}
.info-value{font-size:14px;font-weight:500;color:#e8e9f0;}
.divider{border:none;border-top:1px solid #2a2d3a;margin:24px 0;}
.total-row{display:flex;justify-content:space-between;align-items:center;padding:14px 16px;background:#0f1117;border-radius:8px;margin-top:8px;}
.total-label{font-size:13px;color:#9496a8;}
.total-value{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#f59e0b;}
.terms-box{background:#0f1117;border-radius:8px;padding:16px;font-size:13px;color:#9496a8;line-height:1.7;}
@media(max-width:560px){.info-grid{grid-template-columns:1fr;}.contract-head{flex-direction:column;}}
</style>

<a href="{{ route('client.contracts') }}" class="back-link">← Retour aux contrats</a>

<div class="contract-wrapper">
    <div class="contract-doc">
        <div class="contract-head">
            <div>
                <div class="contract-logo">Auto<em>Loc</em></div>
                <div class="contract-num">Contrat N° {{ $contract->contract_number }}</div>
                <div class="contract-num" style="margin-top:4px;">Créé le {{ $contract->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            <span class="sp" style="
                @if($contract->status=='signed') background:#0d2e1a;color:#4ade80;
                @elseif($contract->status=='draft') background:#2e1f05;color:#fbbf24;
                @else background:#1a1a2e;color:#a78bfa; @endif
            ">{{ ucfirst($contract->status) }}</span>
        </div>

        <div class="contract-body">
            <div class="section-title">Informations client</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nom complet</div>
                    <div class="info-value">{{ $contract->rental->user->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $contract->rental->user->email }}</div>
                </div>
                @if($contract->rental->user->phone)
                <div class="info-item">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">{{ $contract->rental->user->phone }}</div>
                </div>
                @endif
                @if($contract->rental->user->cin)
                <div class="info-item">
                    <div class="info-label">N° CNI</div>
                    <div class="info-value">{{ $contract->rental->user->cin }}</div>
                </div>
                @endif
            </div>

            <hr class="divider">

            <div class="section-title">Véhicule loué</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Véhicule</div>
                    <div class="info-value">{{ $contract->rental->vehicle->brand }} {{ $contract->rental->vehicle->model }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Immatriculation</div>
                    <div class="info-value">{{ $contract->rental->vehicle->plate }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date de début</div>
                    <div class="info-value">{{ $contract->rental->start_date->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date de fin</div>
                    <div class="info-value">{{ $contract->rental->end_date->format('d/m/Y') }}</div>
                </div>
            </div>

            <hr class="divider">

            <div class="section-title">Récapitulatif financier</div>
            <div class="total-row">
                <span class="total-label">Durée</span>
                <span class="total-value" style="color:#e8e9f0;">{{ $contract->rental->total_days }} jour(s)</span>
            </div>
            <div class="total-row" style="margin-top:8px;">
                <span class="total-label">Prix/jour</span>
                <span class="total-value" style="color:#e8e9f0;">{{ number_format($contract->rental->vehicle->price_per_day,0,',',' ') }} FCFA</span>
            </div>
            <div class="total-row" style="margin-top:8px;">
                <span class="total-label">Caution (30%)</span>
                <span class="total-value" style="color:#e8e9f0;">{{ number_format($contract->deposit_amount,0,',',' ') }} FCFA</span>
            </div>
            <div class="total-row" style="margin-top:8px;border:1px solid #f59e0b;">
                <span class="total-label" style="color:#fff;font-weight:600;">TOTAL</span>
                <span class="total-value">{{ number_format($contract->rental->total_price,0,',',' ') }} FCFA</span>
            </div>

            @if($contract->terms)
            <hr class="divider">
            <div class="section-title">Conditions générales</div>
            <div class="terms-box">{{ $contract->terms }}</div>
            @endif
        </div>
    </div>

    <div style="margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('client.contracts') }}" style="padding:10px 20px;border:1px solid #2a2d3a;border-radius:8px;color:#9496a8;text-decoration:none;font-size:13px;">← Retour</a>
        <button onclick="window.print()" style="padding:10px 20px;background:#1e2130;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:13px;cursor:pointer;font-family:'DM Sans',sans-serif;">Imprimer</button>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title','Mes Contrats')
@section('content')
<style>
.contract-list{display:flex;flex-direction:column;gap:12px;}
.contract-card{background:#161820;border:1px solid #2a2d3a;border-radius:12px;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;transition:.2s;}
.contract-card:hover{border-color:#2a2d4a;}
.contract-num{font-family:'Syne',sans-serif;font-size:15px;font-weight:600;color:#fff;}
.contract-sub{font-size:12px;color:#555870;margin-top:3px;}
.sp{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;}
.btn-sm{font-size:12px;padding:6px 14px;border-radius:8px;background:#1e2130;color:#9496a8;text-decoration:none;border:1px solid #2a2d3a;}
.btn-sm:hover{color:#fff;}
.empty-state{text-align:center;padding:80px;color:#555870;}
</style>

<div style="margin-bottom:28px;">
    <h1 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;">Mes Contrats</h1>
    <p style="color:#9496a8;font-size:13px;margin-top:2px;">{{ $contracts->total() }} contrat(s)</p>
</div>

@if($contracts->isEmpty())
    <div class="empty-state">
        <p style="font-size:15px;color:#e8e9f0;margin-bottom:8px;">Aucun contrat pour le moment</p>
        <p style="font-size:13px;">Les contrats sont générés automatiquement lors de vos réservations.</p>
    </div>
@else
    <div class="contract-list">
        @foreach($contracts as $contract)
        <div class="contract-card">
            <div>
                <div class="contract-num">{{ $contract->contract_number }}</div>
                <div class="contract-sub">
                    {{ $contract->rental->vehicle->brand }} {{ $contract->rental->vehicle->model }}
                    · {{ $contract->rental->start_date->format('d/m/Y') }} → {{ $contract->rental->end_date->format('d/m/Y') }}
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <div style="text-align:right;">
                    <div style="font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:#f59e0b;">
                        {{ number_format($contract->rental->total_price,0,',',' ') }} F
                    </div>
                    <div style="font-size:11px;color:#555870;">
                        Caution : {{ number_format($contract->deposit_amount,0,',',' ') }} F
                    </div>
                </div>
                <span class="sp" style="
                    @if($contract->status=='signed') background:#0d2e1a;color:#4ade80;
                    @elseif($contract->status=='draft') background:#2e1f05;color:#fbbf24;
                    @else background:#1a1a2e;color:#a78bfa; @endif
                ">{{ ucfirst($contract->status) }}</span>
                <a href="{{ route('client.contracts.show',$contract) }}" class="btn-sm">Voir →</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top:24px;display:flex;justify-content:center;">{{ $contracts->links() }}</div>
@endif
@endsection
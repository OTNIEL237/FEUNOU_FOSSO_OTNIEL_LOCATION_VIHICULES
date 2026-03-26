@extends('layouts.app')
@section('title','Paiements')
@section('content')
<style>
.card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
.card-header{padding:18px 24px;border-bottom:1px solid #2a2d3a;display:flex;justify-content:space-between;align-items:center;}
.card-header h2{font-family:'Syne',sans-serif;font-size:15px;font-weight:600;color:#fff;}
table{width:100%;border-collapse:collapse;}
th{padding:10px 20px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.9px;background:#0f1117;}
td{padding:13px 20px;font-size:13px;color:#9496a8;border-top:1px solid #1a1c2a;}
td strong{color:#e8e9f0;}
tr:hover td{background:#0f1117;}
.sp{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.alert{padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;}
</style>

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div><h1>Paiements</h1><p>{{ $payments->total() }} paiement(s)</p></div>
    <div style="background:#161820;border:1px solid #2a2d3a;border-radius:10px;padding:16px 24px;">
        <div style="font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.8px;">Total encaissé</div>
        <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#f59e0b;margin-top:4px;">
            {{ number_format($payments->where('status','paid')->sum('amount'),0,',',' ') }} FCFA
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>Référence</th><th>Client</th><th>Véhicule</th><th>Montant</th><th>Méthode</th><th>Statut</th><th>Date</th></tr>
        </thead>
        <tbody>
            @forelse($payments as $p)
            <tr>
                <td><strong>{{ $p->transaction_ref ?? '—' }}</strong></td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->rental->vehicle->brand }} {{ $p->rental->vehicle->model }}</td>
                <td><strong style="color:#f59e0b;">{{ number_format($p->amount,0,',',' ') }} F</strong></td>
                <td>{{ ucfirst($p->method) }}</td>
                <td>
                    <span class="sp" style="
                        @if($p->status=='paid') background:#0d2e1a;color:#4ade80;
                        @elseif($p->status=='pending') background:#2e1f05;color:#fbbf24;
                        @elseif($p->status=='refunded') background:#1a1a2e;color:#a78bfa;
                        @else background:#2e0d0d;color:#f87171; @endif
                    ">{{ ucfirst($p->status) }}</span>
                </td>
                <td>{{ $p->paid_at ? $p->paid_at->format('d/m/Y') : '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:48px;color:#555870;">Aucun paiement</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $payments->links() }}</div>
</div>
@endsection
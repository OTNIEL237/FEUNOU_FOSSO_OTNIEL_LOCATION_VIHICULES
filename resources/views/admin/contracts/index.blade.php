@extends('layouts.app')
@section('title','Contrats')
@section('content')
<style>
.card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
table{width:100%;border-collapse:collapse;}
th{padding:10px 20px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.9px;background:#0f1117;}
td{padding:13px 20px;font-size:13px;color:#9496a8;border-top:1px solid #1a1c2a;}
td strong{color:#e8e9f0;}
tr:hover td{background:#0f1117;}
.sp{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.alert{padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;}
select.st-select{background:#0f1117;border:1px solid #2a2d3a;border-radius:6px;color:#e8e9f0;padding:4px 8px;font-size:12px;font-family:'DM Sans',sans-serif;}
</style>

<div class="page-header"><h1>Contrats</h1><p>{{ $contracts->total() }} contrat(s)</p></div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>N° Contrat</th><th>Client</th><th>Véhicule</th><th>Période</th><th>Montant</th><th>Caution</th><th>Statut</th></tr>
        </thead>
        <tbody>
            @forelse($contracts as $c)
            <tr>
                <td><strong>{{ $c->contract_number }}</strong><br><span style="font-size:11px;color:#555870;">{{ $c->created_at->format('d/m/Y') }}</span></td>
                <td>{{ $c->rental->user->name }}</td>
                <td>{{ $c->rental->vehicle->brand }} {{ $c->rental->vehicle->model }}</td>
                <td style="white-space:nowrap;font-size:12px;">{{ $c->rental->start_date->format('d/m/Y') }} → {{ $c->rental->end_date->format('d/m/Y') }}</td>
                <td><strong>{{ number_format($c->rental->total_price,0,',',' ') }} F</strong></td>
                <td>{{ number_format($c->deposit_amount,0,',',' ') }} F</td>
                <td>
                    <form method="POST" action="{{ route('admin.contracts.update',$c) }}" style="display:flex;gap:6px;align-items:center;">
                        @csrf @method('PUT')
                        <select name="status" class="st-select">
                            @foreach(['draft','signed','closed'] as $s)
                            <option value="{{ $s }}" {{ $c->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" style="background:#f59e0b;color:#0f1117;border:none;border-radius:6px;padding:5px 10px;font-size:11px;font-weight:700;cursor:pointer;font-family:'Syne',sans-serif;">OK</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:48px;color:#555870;">Aucun contrat</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $contracts->links() }}</div>
</div>
@endsection
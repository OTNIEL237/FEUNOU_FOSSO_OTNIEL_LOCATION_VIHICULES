@extends('layouts.app')
@section('title','Locations')
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
select.status-select{background:#0f1117;border:1px solid #2a2d3a;border-radius:6px;color:#e8e9f0;padding:4px 8px;font-size:12px;font-family:'DM Sans',sans-serif;}
</style>

<div class="page-header"><h1>Locations</h1><p>{{ $rentals->total() }} location(s) au total</p></div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>Client</th><th>Véhicule</th><th>Période</th><th>Jours</th><th>Prix</th><th>Statut</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($rentals as $r)
            <tr>
                <td><strong>{{ $r->user->name }}</strong><br><span style="font-size:11px;color:#555870;">{{ $r->user->email }}</span></td>
                <td>{{ $r->vehicle->brand }} {{ $r->vehicle->model }}<br><span style="font-size:11px;color:#555870;">{{ $r->vehicle->plate }}</span></td>
                <td style="white-space:nowrap;">{{ $r->start_date->format('d/m/Y') }}<br>{{ $r->end_date->format('d/m/Y') }}</td>
                <td>{{ $r->total_days }}j</td>
                <td><strong>{{ number_format($r->total_price,0,',',' ') }} F</strong></td>
                <td>
                    <span class="sp" style="
                        @if($r->status=='ongoing') background:#0d2e1a;color:#4ade80;
                        @elseif($r->status=='pending') background:#2e1f05;color:#fbbf24;
                        @elseif($r->status=='confirmed') background:#071e38;color:#60a5fa;
                        @elseif($r->status=='completed') background:#1a1a2e;color:#a78bfa;
                        @else background:#2e0d0d;color:#f87171; @endif
                    ">{{ ucfirst($r->status) }}</span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.rentals.status',$r) }}" style="display:flex;gap:6px;align-items:center;">
                        @csrf @method('PATCH')
                        <select name="status" class="status-select">
                            @foreach(['pending','confirmed','ongoing','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $r->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" style="background:#f59e0b;color:#0f1117;border:none;border-radius:6px;padding:5px 10px;font-size:11px;font-weight:700;cursor:pointer;font-family:'Syne',sans-serif;">OK</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:48px;color:#555870;">Aucune location</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $rentals->links() }}</div>
</div>
@endsection
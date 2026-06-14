@extends('layouts.app')
@push('styles')
<style>

.transaction-topbar { display: flex; align-items: center; justify-content: space-between; background: #fff; border-bottom: 1px solid #eee; padding: 12px 24px; }
.vtype-btns { display: flex; gap: 8px; }
.vtype-btn {
    background: #e91e8c; color: #fff; border: none; border-radius: 6px; padding: 7px 16px;
    font-size: 12px; font-weight: 600; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px;
}
.vtype-btn.selected { background: #7b1fa2; }

.transaction-main { display: grid; grid-template-columns: 1fr 280px; gap: 20px; padding: 20px 24px; }

/* Left panel: date + location cards */
.loc-cards {
    display: flex;
    gap: 16px;
    flex-wrap: nowrap;
    align-items: flex-start; }
.loc-card{
    background:#fff;
    color:#333;
    border-radius:25px;
    width:160px;
    min-height:180px;
    padding:15px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.building-icon{
    width:55px;
    height:55px;
    font-size:22px;
    margin:0 auto 20px;
    border-radius:20px;
    background:linear-gradient(135deg,#ff1493,#8a2be2);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:28px;
    color:white;
}

.loc-name{
    font-size:16px;
    font-weight:700;
    margin-bottom:10px;
}

.status-row{
    display:flex;
    justify-content:center;
    gap:10px;
    font-size:14px;
    font-weight:700;
}

.green{
    color:green;
}
.loc-card.selected { border-color: #e91e8c; transform: scale(1.03); }
.loc-card .loc-name { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
.loc-card .loc-max { font-size: 11px; opacity: 0.75; margin-bottom: 10px; }
.loc-card .loc-slots { display: flex; gap: 14px; font-size: 12px; }
.loc-slot { display: flex; align-items: center; gap: 5px; font-weight: 600; }
.loc-slot i { font-size: 14px; }

.clock-card {
    background: url('{{ asset("img/curved19.jpg") }}') center/cover;
    color: #fff;
    border-radius: 25px;
    width:150px;
    height:220px;
    padding:15px;
    text-align: center;
    align-items: center;
}
.clock-day { font-size: 12px; font-weight: 600; margin-bottom: 2px; }
.clock-date { font-size: 10px; opacity: 0.7; margin-bottom: 10px; }
.clock-time { font-size: 18px; font-weight: 700; letter-spacing: 2px; }
.clock-logo{ width:45px; margin-bottom:20px; }

/* Transaction form */
.trans-form-card { background: #fff; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,0.07); padding: 20px; }
.trans-form-title { color: #e91e8c; font-size: 15px; font-weight: 700; margin-bottom: 16px; }
.trans-form-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.trans-input {
    width: 100%; padding: 10px 14px; border: 2px solid #e91e8c;
    border-radius: 6px; font-size: 13px; font-family: 'Poppins', sans-serif;
    outline: none; color: #333;
}
.trans-input:focus { box-shadow: 0 0 0 3px rgba(233,30,140,0.12); }
.trans-form-actions { display: flex; justify-content: flex-end; margin-top: 12px; }
.btn-exit { background: linear-gradient(135deg, #7b1fa2, #e91e8c); color: #fff; border: none; border-radius: 6px; padding: 9px 20px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 7px; }
.btn-enter { background: linear-gradient(135deg, #e91e8c, #7b1fa2); color: #fff; border: none; border-radius: 6px; padding: 9px 20px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 7px; }

/* Right panel: tickets */
.tickets-panel { }
.tickets-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
.tickets-title { font-size: 14px; font-weight: 700; color: #333; }
.btn-view-all { background: #fff; border: 1px solid #ddd; color: #555; border-radius: 6px; padding: 5px 12px; font-size: 11px; font-weight: 600; cursor: pointer; text-decoration: none; }
.btn-view-all:hover { background: #f5f5f5; }
.ticket-item {
    background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    padding: 12px 14px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;
}
.ticket-info { font-size: 11px; color: #555; }
.ticket-num { font-size: 12px; font-weight: 700; color: #222; margin-top: 2px; cursor: pointer; }
.ticket-num:hover { color: #e91e8c; text-decoration: underline; }
.ticket-price { font-size: 13px; font-weight: 700; color: #333; }
.ticket-pdf-btn { background: #fff3f8; border: 1px solid #f8a0ce; color: #e91e8c; border-radius: 5px; padding: 4px 10px; font-size: 11px; font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 4px; }
.ticket-pdf-btn:hover { background: #fde8f3; }
</style>
@endpush
@section('content')

{{-- Success modal (new ticket) --}}
@if(session('total_bayar') !== null)
<div id="payModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-total">Total Bayar : Rp {{ number_format(session('total_bayar'),0,',','.') }}</div>
        <button class="modal-btn" onclick="document.getElementById('payModal').style.display='none'">OK</button>
    </div>
</div>
@endif

<!-- Topbar with vehicle type buttons -->
<div class="transaction-topbar">
    <div>
        <div class="breadcrumb">Pages / Transaction</div>
        <span style="font-size:15px;font-weight:700;color:#333;">Transaction</span>
    </div>
    <div style="display:flex;align-items:center;gap:10px;">
        <div class="vtype-btns" id="vtypeBtns">
            @foreach($vehicleTypes as $vt)
                <button class="vtype-btn {{ $loop->first ? 'selected' : '' }}"
                    data-id="{{ $vt->id }}" data-jenis="{{ $vt->jenis }}"
                    onclick="selectVehicleType(this)">
                    {{ strtoupper($vt->jenis === 'motorcycle' ? 'MOTORCYCLE' : ($vt->jenis === 'car' ? 'CAR' : 'OTHER')) }}
                </button>
            @endforeach
        </div>
        <button class="btn-enter" onclick="enterVehicle()"><i class="fa-solid fa-plus"></i> ENTER VEHICLE</button>
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>

<div class="transaction-main">
    <!-- Left -->
    <div>
        <div class="loc-cards">
            <!-- Clock card -->
            <div class="clock-card">
            <img src="{{ asset('img/parkir.png') }}" class="clock-logo">
            <div class="clock-day" id="clockDay"></div>
            <div class="clock-date" id="clockDate"></div>
            <div class="clock-time" id="clockTime"></div>
        </div>

            @foreach($locations as $loc)
            <div class="loc-card {{ $loop->first ? 'selected' : '' }}"
                id="locCard{{ $loc->id }}"
                data-id="{{ $loc->id }}"
                onclick="selectLocation(this)">

         <div class="building-icon">
            <i class="fa-solid fa-building-columns"></i>
        </div>

        <div class="loc-name">
            {{ $loc->location_name }}
        </div>

        <div class="loc-max">
            🏍 {{ $loc->max_motorcycle }}
            🚗 {{ $loc->max_car }}
            🚚 {{ $loc->max_other }}
        </div>
            <hr style="margin:15px 0;border:1px solid #eee;">

        <div class="status-row">
            <span class="green">
                🏍 {{ $locationSlots[$loc->id]['motorcycle'] }}
            </span>
            <span class="green">
                🚗 {{ $locationSlots[$loc->id]['car'] }}
            </span>
            <span class="green">
                🚚 {{ $locationSlots[$loc->id]['other'] }}
            </span>
        </div>
    </div>
            @endforeach
        </div>

        <!-- Transaction form -->
        <div class="trans-form-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                <div class="trans-form-title">Transaction Input Form</div>
                <form id="exitForm" method="POST" action="{{ route('transaction.exit') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="no_tiket" id="hiddenNoTiket">
                    <input type="hidden" name="no_polisi" id="hiddenNoPolisi">
                    <button type="button" class="btn-exit" onclick="exitVehicle()"><i class="fa-solid fa-plus"></i> EXIT VEHICLE</button>
                </form>
            </div>
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif
            <div class="trans-form-fields">
                <div>
                    <label style="font-size:11px;color:#aaa;font-weight:600;">Ticket Number</label>
                    <textarea id="noTiketInput" class="trans-input" rows="3" placeholder="" style="width:100%;resize:none;"></textarea>
                </div>
                <div>
                    <label style="font-size:11px;color:#aaa;font-weight:600;">Police Number</label>
                    <input type="text" id="noPolisiInput" class="trans-input" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Tickets -->
    <div class="tickets-panel">
        <div class="tickets-header">
            <div class="tickets-title">Tickets</div>
            <a href="{{ route('transaction.all') }}" class="btn-view-all">VIEW ALL</a>
        </div>
        @forelse($tickets->take(10) as $ticket)
        <div class="ticket-item">
            <div>
                <div class="ticket-info">
                    {{ optional($ticket->masuk)->format('Y-m-d H:i:s') }}
                </div>
                <div style="font-size:11px;color:#888;">
                    {{ ucfirst($ticket->vehicleType?->jenis ?? '-') }}
                </div>
                <div class="ticket-num" onclick="fillTicket('{{ $ticket->no_tiket }}')">#{{ $ticket->no_tiket }}</div>
            </div>
            <div style="text-align:right;">
                @if($ticket->total_bayar !== null)
                    <div class="ticket-price">Rp {{ number_format($ticket->total_bayar,0,',','.') }}</div>
                @endif
                <a href="{{ route('transaction.pdf', $ticket->id) }}" target="_blank" class="ticket-pdf-btn">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>
        @empty
        <div style="text-align:center;color:#aaa;padding:20px;font-size:13px;">No tickets yet</div>
        @endforelse
    </div>
</div>

<!-- Hidden forms -->
<form id="enterForm" method="POST" action="{{ route('transaction.enter') }}" style="display:none;">
    @csrf
    <input type="hidden" name="id_lokasi" id="selectedLokasi" value="{{ $locations->first()?->id }}">
    <input type="hidden" name="id_jenis" id="selectedJenis" value="{{ $vehicleTypes->first()?->id }}">
</form>

@push('scripts')
<script>
let selectedLocId = {{ $locations->first()?->id ?? 'null' }};
let selectedVtId = {{ $vehicleTypes->first()?->id ?? 'null' }};

function selectLocation(el) {
    document.querySelectorAll('.loc-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    selectedLocId = el.dataset.id;
    document.getElementById('selectedLokasi').value = selectedLocId;
}

function selectVehicleType(el) {
    document.querySelectorAll('.vtype-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    selectedVtId = el.dataset.id;
    document.getElementById('selectedJenis').value = selectedVtId;
}

function enterVehicle() {
    document.getElementById('selectedLokasi').value = selectedLocId;
    document.getElementById('selectedJenis').value = selectedVtId;
    document.getElementById('enterForm').submit();
}

function exitVehicle() {
    const noTiket = document.getElementById('noTiketInput').value.trim();
    const noPolisi = document.getElementById('noPolisiInput').value.trim();
    if (!noTiket || !noPolisi) {
        alert('Isi Ticket Number dan Police Number!');
        return;
    }
    document.getElementById('hiddenNoTiket').value = noTiket;
    document.getElementById('hiddenNoPolisi').value = noPolisi;
    document.getElementById('exitForm').submit();
}

function fillTicket(noTiket) {
    document.getElementById('noTiketInput').value = noTiket;
}

// Clock
function updateClock() {
    const now = new Date();
    const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    document.getElementById('clockDay').textContent = days[now.getDay()];
    document.getElementById('clockDate').textContent = now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
    const h = String(now.getHours()).padStart(2,'0');
    const m = String(now.getMinutes()).padStart(2,'0');
    const s = String(now.getSeconds()).padStart(2,'0');
    document.getElementById('clockTime').textContent = h + ' : ' + m + ' : ' + s;
}
updateClock();
setInterval(updateClock, 1000);

// Init selectedJenis from first button
const firstVtype = document.querySelector('.vtype-btn');
if (firstVtype) selectedVtId = firstVtype.dataset.id;
document.getElementById('selectedJenis').value = selectedVtId;
</script>
@endpush
@endsection

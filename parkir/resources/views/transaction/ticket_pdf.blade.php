<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; color: #111; }
.ticket { max-width: 300px; margin: 0 auto; text-align: center; border: 1px solid #ddd; padding: 20px; }
.company-name { font-weight: bold; font-size: 14px; margin-bottom: 4px; }
.company-addr { font-size: 10px; color: #555; margin-bottom: 16px; line-height: 1.5; }
.ticket-title { font-size: 16px; font-weight: bold; margin: 12px 0 8px; text-transform: uppercase; }
.ticket-loc { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
.ticket-type { font-size: 13px; font-weight: bold; margin-bottom: 16px; }
.ticket-no { font-size: 11px; margin-bottom: 4px; }
.ticket-date { font-size: 11px; margin-bottom: 16px; }
.ticket-warn { font-size: 10px; font-weight: bold; color: #333; text-transform: uppercase; }
</style>
</head>
<body>
<div class="ticket">
    <div class="company-name">SIJA PARKING</div>
    <div class="company-addr">Jl. Raya Karademan No 7, Karademan,<br>Kec. Cibinong, Kabupaten Bogor, Jawa<br>Barat 16111</div>
    <div class="ticket-title">TIKET PARKIR</div>
    <div class="ticket-loc">{{ $transaction->location?->location_name }}</div>
    <div class="ticket-type">{{ $jenisLabel }}</div>
    <div class="ticket-no">No Tiket : {{ $transaction->no_tiket }}</div>
    <div class="ticket-date">Tanggal : {{ optional($transaction->masuk)->format('Y-m-d H:i:s') }}</div>
    <div class="ticket-warn">JANGAN MENINGGALKAN TIKET DAN BARANG<br>BERHARGA DI DALAM KENDARAAN</div>
</div>
</body>
</html>

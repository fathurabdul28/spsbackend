<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Donasi - Sehati Peduli</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; }
        .header h2 { margin: 0 0 5px 0; color: #0f172a; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #1e293b; color: #ffffff; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-warning { background-color: #fef9c3; color: #a16207; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        .total-box { margin-top: 20px; text-align: right; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Donasi</h2>
        <p>Yayasan Sehati Peduli Sesama | Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Donatur</th>
                <th>Kontak</th>
                <th>Program Donasi</th>
                <th>Jumlah</th>
                <th>Tipe</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $index => $donation)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $donation->created_at ? $donation->created_at->format('d/m/Y H:i') : '-' }}</td>
                <td><strong>{{ $donation->donor_name }}</strong></td>
                <td>{{ $donation->donor_email }}<br><small style="color: #64748b;">{{ $donation->donor_phone ?? '-' }}</small></td>
                <td>{{ $donation->program ? $donation->program->title : '-' }}</td>
                <td><strong>Rp {{ number_format($donation->amount, 0, ',', '.') }}</strong></td>
                <td>{{ strtoupper($donation->payment_type ?? 'MANUAL') }}</td>
                <td>
                    @if($donation->status === 'approved')
                        <span class="badge badge-success">Approved</span>
                    @elseif($donation->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-danger">{{ ucfirst($donation->status) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada data donasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Total Donasi Disetujui: Rp {{ number_format($donations->where('status', 'approved')->sum('amount'), 0, ',', '.') }}
    </div>
</body>
</html>

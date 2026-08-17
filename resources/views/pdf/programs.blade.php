<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Program Donasi - Sehati Peduli</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; }
        .header h2 { margin: 0 0 5px 0; color: #0f766e; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #0f766e; color: #ffffff; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-secondary { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Program Donasi</h2>
        <p>Yayasan Sehati Peduli Sesama | Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Program</th>
                <th>Kategori</th>
                <th>Target Dana</th>
                <th>Terkumpul</th>
                <th>Capaian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $index => $program)
            @php
                $collected = $program->donations->where('status', 'approved')->sum('amount');
                $target = $program->target_amount ?: 1;
                $progress = round(($collected / $target) * 100, 1);
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $program->title }}</strong></td>
                <td>{{ $program->category ? $program->category->name : '-' }}</td>
                <td>Rp {{ number_format($program->target_amount, 0, ',', '.') }}</td>
                <td><strong style="color: #10b981;">Rp {{ number_format($collected, 0, ',', '.') }}</strong></td>
                <td><strong>{{ $progress }}%</strong></td>
                <td>
                    @if($program->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Nonaktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada data program.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data User - Sehati Peduli</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; }
        .header h2 { margin: 0 0 5px 0; color: #0f172a; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #1e293b; color: #ffffff; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .total-box { margin-top: 20px; text-align: right; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Pengguna (User)</h2>
        <p>Yayasan Sehati Peduli Sesama | Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->id }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada data pengguna.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-box">
        Total Pengguna: {{ $users->count() }} Orang
    </div>
</body>
</html>

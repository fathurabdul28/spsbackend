<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Berita & Artikel - Sehati Peduli</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; }
        .header h2 { margin: 0 0 5px 0; color: #1d4ed8; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #64748b; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #1d4ed8; color: #ffffff; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Berita & Artikel</h2>
        <p>Yayasan Sehati Peduli Sesama | Dicetak pada: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Berita</th>
                <th>Slug URL</th>
                <th>Penulis</th>
                <th>Tanggal Rilis</th>
            </tr>
        </thead>
        <tbody>
            @forelse($newsList as $index => $news)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $news->title }}</strong></td>
                <td><code style="color: #2563eb;">{{ $news->slug }}</code></td>
                <td>{{ $news->author ? $news->author->name : 'Admin' }}</td>
                <td>{{ $news->created_at ? $news->created_at->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada berita dipublikasikan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

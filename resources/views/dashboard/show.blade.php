@extends('layouts.grain')

@section('title', 'Dashboard')

@section('content')

@include('components.notification')

<div class="mb-3 mb-md-4 d-flex justify-content-between align-items-center flex-wrap">
	<div>
		<div class="h3 mb-0">Dashboard Admin</div>
		<div class="text-muted small">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</div>
	</div>

	<!-- Filter Rentang Waktu (Sesuai dengan Filter Filament di backend lama) -->
	<div class="mt-2 mt-md-0">
		<form method="GET" action="{{ route('dashboard') }}" class="form-inline" id="periodFilterForm">
			<label class="mr-2 font-weight-semi-bold text-muted small mb-0" for="period">Rentang Waktu:</label>
			<select name="period" id="period" class="form-control form-control-sm custom-select custom-select-sm" onchange="document.getElementById('periodFilterForm').submit()">
				<option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
				<option value="week" {{ $period === 'week' ? 'selected' : '' }}>Minggu Ini</option>
				<option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
				<option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahun Ini</option>
				<option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Waktu</option>
			</select>
		</form>
	</div>
</div>

<!-- Statistik Utama -->
<div class="row">
	<div class="col-md-6 col-xl-3 mb-3 mb-xl-4">
		<div class="card flex-row align-items-center p-3 p-md-4">
			<div class="icon icon-lg bg-soft-primary rounded-circle mr-3">
				<i class="gd-wallet icon-text d-inline-block text-primary"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">Rp {{ number_format($totalDonations, 0, ',', '.') }}</h4>
				<h6 class="mb-0 text-muted">Total Donasi Masuk</h6>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-xl-3 mb-3 mb-xl-4">
		<div class="card flex-row align-items-center p-3 p-md-4">
			<div class="icon icon-lg bg-soft-success rounded-circle mr-3">
				<i class="gd-layers icon-text d-inline-block text-success"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{ $activePrograms }} / {{ $totalPrograms }}</h4>
				<h6 class="mb-0 text-muted">Program Aktif</h6>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-xl-3 mb-3 mb-xl-4">
		<div class="card flex-row align-items-center p-3 p-md-4">
			<div class="icon icon-lg bg-soft-warning rounded-circle mr-3">
				<i class="gd-user icon-text d-inline-block text-warning"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{ $totalDonors }}</h4>
				<h6 class="mb-0 text-muted">Total Donatur</h6>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-xl-3 mb-3 mb-xl-4">
		<div class="card flex-row align-items-center p-3 p-md-4">
			<div class="icon icon-lg bg-soft-secondary rounded-circle mr-3">
				<i class="gd-bar-chart icon-text d-inline-block text-secondary"></i>
			</div>
			<div>
				<h4 class="lh-1 mb-1">{{ $totalDonationCount }}</h4>
				<h6 class="mb-0 text-muted">Total Transaksi</h6>
			</div>
		</div>
	</div>
</div>

<!-- Section Diagram / Charts (Batang & Lingkaran) -->
<div class="row">
	<!-- Diagram Batang: Rekap Donasi per Program -->
	<div class="col-lg-7 mb-3 mb-md-4">
		<div class="card h-100">
			<div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 font-weight-semi-bold">
					<i class="gd-bar-chart icon-text text-primary mr-2"></i> Rekap Donasi per Program (Rp)
				</h5>
				<span class="badge badge-soft-primary">Diagram Batang</span>
			</div>
			<div class="card-body p-3">
				<div style="position: relative; height: 300px; width: 100%;">
					<canvas id="donationBarChart"></canvas>
				</div>
			</div>
		</div>
	</div>

	<!-- Diagram Lingkaran: Jumlah Donatur per Program -->
	<div class="col-lg-5 mb-3 mb-md-4">
		<div class="card h-100">
			<div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
				<h5 class="mb-0 font-weight-semi-bold">
					<i class="gd-pie-chart icon-text text-success mr-2"></i> Jumlah Donatur per Program
				</h5>
				<span class="badge badge-soft-success">Diagram Lingkaran</span>
			</div>
			<div class="card-body p-3">
				<div style="position: relative; height: 300px; width: 100%;">
					<canvas id="donorPieChart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Donasi Terbaru -->
	<div class="col-md-7 mb-3 mb-md-4">
		<div class="card">
			<div class="card-header d-flex align-items-center border-bottom py-3">
				<h5 class="mb-0">Donasi Terbaru</h5>
				<a href="{{ route('donation.index') }}" class="link small ml-auto">Lihat Semua</a>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead>
							<tr>
								<th class="font-weight-semi-bold border-top-0 py-2">Donatur</th>
								<th class="font-weight-semi-bold border-top-0 py-2">Program</th>
								<th class="font-weight-semi-bold border-top-0 py-2">Jumlah</th>
								<th class="font-weight-semi-bold border-top-0 py-2">Status</th>
							</tr>
						</thead>
						<tbody>
						@forelse($recentDonations as $donation)
							<tr>
								<td class="py-2">
									<div class="font-weight-semi-bold">{{ $donation->donor_name }}</div>
									<small class="text-muted">{{ $donation->donor_email }}</small>
								</td>
								<td class="py-2">{{ $donation->program->title ?? '-' }}</td>
								<td class="py-2">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
								<td class="py-2">
									@if($donation->status === 'settlement' || $donation->status === 'success')
										<span class="badge badge-success">Sukses</span>
									@elseif($donation->status === 'pending')
										<span class="badge badge-warning">Pending</span>
									@elseif($donation->status === 'cancel')
										<span class="badge badge-danger">Dibatalkan</span>
									@else
										<span class="badge badge-secondary">{{ $donation->status }}</span>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center py-3 text-muted">Belum ada donasi.</td>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Program Terbaru -->
	<div class="col-md-5 mb-3 mb-md-4">
		<div class="card">
			<div class="card-header d-flex align-items-center border-bottom py-3">
				<h5 class="mb-0">Program Terbaru</h5>
				<a href="{{ route('program.index') }}" class="link small ml-auto">Lihat Semua</a>
			</div>
			<div class="card-body p-0">
				<div class="list-group list-group-flush">
				@forelse($recentPrograms as $program)
					<a href="{{ route('program.edit', $program) }}" class="list-group-item list-group-item-action py-3">
						<div class="d-flex align-items-center">
							<div class="media-body">
								<div class="font-weight-semi-bold">{{ Str::limit($program->title, 40) }}</div>
								<small class="text-muted">{{ $program->category->name ?? 'Tanpa Kategori' }}</small>
							</div>
							@if($program->is_active)
								<span class="badge badge-success ml-2">Aktif</span>
							@else
								<span class="badge badge-secondary ml-2">Nonaktif</span>
							@endif
						</div>
					</a>
				@empty
					<div class="list-group-item py-3 text-center text-muted">Belum ada program.</div>
				@endforelse
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Data dari Controller
    const barLabels = {!! json_encode($barLabels) !!};
    const barData   = {!! json_encode($barData) !!};
    const pieLabels = {!! json_encode($pieLabels) !!};
    const pieData   = {!! json_encode($pieData) !!};
    const pieColors = {!! json_encode($pieColors) !!};

    // 1. Chart Batang (Rekap Donasi per Program)
    const ctxBar = document.getElementById('donationBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: barLabels.length > 0 ? barLabels : ['Belum ada data'],
            datasets: [{
                label: 'Total Terkumpul (Rp)',
                data: barData.length > 0 ? barData : [0],
                backgroundColor: 'rgba(124, 58, 237, 0.7)',
                borderColor: '#7c3aed',
                borderWidth: 1.5,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw || 0;
                            return ' Total: Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000) + ' Jt';
                            if (value >= 1000) return 'Rp ' + (value/1000) + ' Rb';
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    });

    // 2. Chart Lingkaran (Jumlah Donatur per Program)
    const ctxPie = document.getElementById('donorPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: pieLabels.length > 0 ? pieLabels : ['Belum ada data'],
            datasets: [{
                label: 'Jumlah Donatur',
                data: pieData.length > 0 ? pieData : [0],
                backgroundColor: pieColors.length > 0 ? pieColors : ['#cbd5e1'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw || 0;
                            return ' Donatur: ' + value + ' orang';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
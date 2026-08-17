<x-filament-widgets::widget>
    <style>
        .custom-stat-card {
            border-radius: 0.75rem;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .custom-stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
        }
        .custom-stat-title {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.9;
            margin: 0;
        }
        .custom-stat-icon-wrapper {
            padding: 0.375rem;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.375rem;
            backdrop-filter: blur(4px);
        }
        .custom-stat-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: white;
        }
        .custom-stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
            position: relative;
            z-index: 1;
            line-height: 1.2;
        }
        .custom-stat-desc {
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            backdrop-filter: blur(4px);
            position: relative;
            z-index: 1;
            margin: 0;
            width: max-content;
        }
        .custom-stat-circle {
            position: absolute;
            bottom: -1.5rem;
            right: -1.5rem;
            width: 6rem;
            height: 6rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(16px);
        }
        .custom-stats-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .custom-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1280px) {
            .custom-stats-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }
    </style>

    <div style="margin-bottom: 1rem;">
        <h2 style="font-size: 1.25rem; font-weight: 700;" class="text-gray-900 dark:text-white">Ringkasan Dashboard</h2>
    </div>
    
    <div class="custom-stats-grid">
        
        <!-- Card 1: Total Pendapatan (Purple Gradient) -->
        <div class="custom-stat-card" style="background: linear-gradient(135deg, #7c3aed 0%, #a78bfa 100%);">
            <div class="custom-stat-header">
                <p class="custom-stat-title">Total Dana Terkumpul</p>
                <div class="custom-stat-icon-wrapper">
                    <svg class="custom-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <h3 class="custom-stat-value">{{ $totalDana }}</h3>
            <p class="custom-stat-desc" style="background-color: rgba(255,255,255,0.2);">Total dana sah</p>
            <div class="custom-stat-circle"></div>
        </div>

        <!-- Card 2: Pengguna Baru (Blue Gradient) -->
        <div class="custom-stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);">
            <div class="custom-stat-header">
                <p class="custom-stat-title">Donatur Baru</p>
                <div class="custom-stat-icon-wrapper">
                    <svg class="custom-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <h3 class="custom-stat-value">{{ $donaturBaru }}</h3>
            <p class="custom-stat-desc" style="background-color: rgba(16, 185, 129, 0.8);">Donatur unik</p>
            <div class="custom-stat-circle"></div>
        </div>

        <!-- Card 3: Proyek Aktif (Teal Gradient) -->
        <div class="custom-stat-card" style="background: linear-gradient(135deg, #14b8a6 0%, #2dd4bf 100%);">
            <div class="custom-stat-header">
                <p class="custom-stat-title">Program Aktif</p>
                <div class="custom-stat-icon-wrapper">
                    <svg class="custom-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <h3 class="custom-stat-value">{{ $programAktif }}</h3>
            <p class="custom-stat-desc" style="background-color: rgba(255,255,255,0.2);">Sedang berjalan</p>
            <div class="custom-stat-circle"></div>
        </div>

        <!-- Card 4: Laporan Pending (Dark/Purple Gradient) -->
        <div class="custom-stat-card" style="background: linear-gradient(135deg, #334155 0%, #64748b 100%);">
            <div class="custom-stat-header">
                <p class="custom-stat-title">Donasi Pending</p>
                <div class="custom-stat-icon-wrapper">
                    <svg class="custom-stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <h3 class="custom-stat-value">{{ $donasiPending }}</h3>
            <p class="custom-stat-desc" style="background-color: rgba(244, 63, 94, 0.8);">Butuh konfirmasi</p>
            <div class="custom-stat-circle"></div>
        </div>

    </div>
</x-filament-widgets::widget>

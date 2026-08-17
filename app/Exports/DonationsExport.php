<?php

namespace App\Exports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DonationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $ids;
    protected $search;
    protected $status;

    public function __construct(array $ids = [], string $search = '', string $status = '')
    {
        $this->ids = $ids;
        $this->search = $search;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Donation::with('program')->latest();

        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('donor_name', 'like', '%' . $this->search . '%')
                  ->orWhere('donor_email', 'like', '%' . $this->search . '%')
                  ->orWhere('donor_phone', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Nama Donatur',
            'Email Donatur',
            'No. Telepon',
            'Program Donasi',
            'Jumlah Donasi (Rp)',
            'Tipe Pembayaran',
            'Status',
        ];
    }

    public function map($donation): array
    {
        return [
            $donation->id,
            $donation->created_at ? $donation->created_at->format('d/m/Y H:i') : '-',
            $donation->donor_name,
            $donation->donor_email,
            $donation->donor_phone ?? '-',
            $donation->program ? $donation->program->title : '-',
            number_format($donation->amount, 0, ',', '.'),
            strtoupper($donation->payment_type ?? 'MANUAL'),
            strtoupper($donation->status ?? 'PENDING'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E293B']
                ]
            ],
        ];
    }
}

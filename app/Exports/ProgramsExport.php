<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProgramsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = Program::with(['category', 'donations'])->latest();
        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Program',
            'Kategori',
            'Target Dana (Rp)',
            'Dana Terkumpul (Rp)',
            'Persentase',
            'Status Aktif',
            'Tanggal Dibuat',
        ];
    }

    public function map($program): array
    {
        $collected = $program->donations->where('status', 'approved')->sum('amount');
        $target = $program->target_amount ?: 1;
        $progress = round(($collected / $target) * 100, 1);

        return [
            $program->id,
            $program->title,
            $program->category ? $program->category->name : '-',
            number_format($program->target_amount, 0, ',', '.'),
            number_format($collected, 0, ',', '.'),
            $progress . '%',
            $program->is_active ? 'AKTIF' : 'NONAKTIF',
            $program->created_at ? $program->created_at->format('d/m/Y') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F766E']]],
        ];
    }
}

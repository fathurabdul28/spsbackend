<?php

namespace App\Exports;

use App\Models\News;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NewsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = News::with('author')->latest();
        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Judul Berita',
            'Slug',
            'Penulis',
            'Tanggal Publikasi',
        ];
    }

    public function map($news): array
    {
        return [
            $news->id,
            $news->title,
            $news->slug,
            $news->author ? $news->author->name : 'Admin',
            $news->created_at ? $news->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']]],
        ];
    }
}

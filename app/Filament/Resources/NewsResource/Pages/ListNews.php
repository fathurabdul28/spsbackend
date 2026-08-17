<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(route('export.news.excel'), openInNewTab: true),
            Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-text')
                ->color('danger')
                ->url(route('export.news.pdf'), openInNewTab: true),
            Actions\CreateAction::make(),
        ];
    }
}

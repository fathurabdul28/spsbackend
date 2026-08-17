<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('program_id')
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
                Forms\Components\TextInput::make('bank_account_id')
                    ->numeric(),
                Forms\Components\TextInput::make('donor_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('donor_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('donor_phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_type')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('proof_of_payment')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('donor_name')
                    ->label('Donor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'warning',
                        'gateway' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->modalHeading('Approve Manual Donation')
                    ->modalDescription('Please verify the proof of payment and confirm the received amount.')
                    ->form([
                        Forms\Components\Placeholder::make('proof_of_payment_view')
                            ->label('Proof of Payment')
                            ->content(fn ($record) => new \Illuminate\Support\HtmlString('
                                <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                                    <a href="'.asset('storage/'.$record->proof_of_payment).'" target="_blank">
                                        <img src="'.asset('storage/'.$record->proof_of_payment).'" style="max-height: 300px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: contain;">
                                    </a>
                                </div>
                            '))
                            ->visible(fn ($record) => filled($record->proof_of_payment)),
                        Forms\Components\TextInput::make('verified_amount')
                            ->label('Verified Amount (Edit jika berbeda)')
                            ->numeric()
                            ->required()
                            ->default(fn ($record) => $record->amount),
                    ])
                    ->action(function (Donation $record, array $data): void {
                        $record->update([
                            'amount' => $data['verified_amount'],
                            'status' => 'approved',
                        ]);
                    })
                    ->visible(fn (Donation $record): bool => $record->status === 'pending' && $record->payment_type === 'manual'),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Manual Donation')
                    ->action(fn (Donation $record) => $record->update(['status' => 'rejected']))
                    ->visible(fn (Donation $record): bool => $record->status === 'pending' && $record->payment_type === 'manual'),
                
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_selected_excel')
                        ->label('Export Excel (Terpilih)')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $ids = $records->pluck('id')->implode(',');
                            return redirect()->route('export.donations.excel', ['ids' => $ids]);
                        }),
                    Tables\Actions\BulkAction::make('export_selected_pdf')
                        ->label('Export PDF (Terpilih)')
                        ->icon('heroicon-o-document-text')
                        ->color('danger')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $ids = $records->pluck('id')->implode(',');
                            return redirect()->route('export.donations.pdf', ['ids' => $ids]);
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}

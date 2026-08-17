<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages;
use App\Filament\Resources\BankAccountResource\RelationManagers;
use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Rekening Bank';
    protected static ?string $modelLabel = 'Rekening Bank';
    protected static ?string $navigationGroup = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->required()
                            ->placeholder('Contoh: BCA, BNI, Mandiri')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('account_number')
                            ->label('Nomor Rekening')
                            ->required()
                            ->numeric()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('account_name')
                            ->label('Atas Nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Bank')
                            ->image()
                            ->directory('bank-logos')
                            ->maxSize(2048),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Nama Bank')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->label('No. Rekening')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_name')
                    ->label('Atas Nama')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebSettingResource\Pages;
use App\Filament\Resources\WebSettingResource\RelationManagers;
use App\Models\WebSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebSettingResource extends Resource
{
    protected static ?string $model = WebSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('about_image')
                            ->image()
                            ->directory('settings')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('about_us_text')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('vision')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('mission')
                            ->schema([
                                Forms\Components\TextInput::make('item')->required(),
                            ])
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->email(),
                        Forms\Components\TextInput::make('contact_phone')
                            ->tel(),
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('social_media')
                            ->keyLabel('Platform')
                            ->valueLabel('URL')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('about_image'),
                Tables\Columns\TextColumn::make('contact_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListWebSettings::route('/'),
            'create' => Pages\CreateWebSetting::route('/create'),
            'edit' => Pages\EditWebSetting::route('/{record}/edit'),
        ];
    }
}

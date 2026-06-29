<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static \UnitEnum|string|null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'System Settings';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('key')
                ->required()
                ->disabled(),
            
            // Render select dropdown for bangla_font setting
            Forms\Components\Select::make('value')
                ->label('Setting Value')
                ->options([
                    'Ekushey Lal Sabuj' => 'Ekushey Lal Sabuj',
                    'Hind Siliguri' => 'Hind Siliguri',
                    'Solaiman Lipi' => 'Solaiman Lipi',
                    'Kalpurush' => 'Kalpurush',
                    'Noto Serif Bengali' => 'Noto Serif Bengali',
                ])
                ->visible(fn ($record) => $record && $record->key === 'bangla_font')
                ->required(),
            
            // Render text input for other settings
            Forms\Components\TextInput::make('value')
                ->label('Setting Value')
                ->hidden(fn ($record) => $record && $record->key === 'bangla_font')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->label('Setting Key')->fontFamily('mono')->searchable(),
                Tables\Columns\TextColumn::make('value')->label('Value')->limit(50),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}

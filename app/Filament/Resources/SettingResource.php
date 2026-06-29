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
                ->label('Setting Key')
                ->required()
                ->disabled(),
            
            // Select dropdown for bangla_font
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

            // Select dropdown for smtp_encryption
            Forms\Components\Select::make('value')
                ->label('Setting Value')
                ->options([
                    'tls' => 'TLS',
                    'ssl' => 'SSL',
                    'none' => 'None / Clear Text',
                ])
                ->visible(fn ($record) => $record && $record->key === 'smtp_encryption')
                ->required(),

            // Password input for smtp_password
            Forms\Components\TextInput::make('value')
                ->label('Setting Value')
                ->password()
                ->revealable()
                ->visible(fn ($record) => $record && $record->key === 'smtp_password'),

            // FileUpload for bg_pattern_image
            Forms\Components\FileUpload::make('value')
                ->label('Background Pattern Image')
                ->image()
                ->directory('settings')
                ->disk('public')
                ->visible(fn ($record) => $record && $record->key === 'bg_pattern_image')
                ->required(),

            // Standard input for other settings
            Forms\Components\TextInput::make('value')
                ->label('Setting Value')
                ->visible(fn ($record) => $record && !in_array($record->key, ['bangla_font', 'smtp_encryption', 'smtp_password', 'bg_pattern_image']))
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Configuration Setting')
                    ->fontFamily('mono')
                    ->description(fn ($record) => match($record->key) {
                        'bangla_font' => 'Active Bengali Font Family on front-end',
                        'whatsapp_number' => 'WhatsApp Contact Link Number (with country code)',
                        'phone_number' => 'Primary Contact Hotline Telephone Number',
                        'contact_email' => 'Official support/contact email address',
                        'smtp_host' => 'Mail Server SMTP Host Address',
                        'smtp_port' => 'Mail Server SMTP Port Number',
                        'smtp_username' => 'Mail Server SMTP Username',
                        'smtp_password' => 'Mail Server SMTP Password',
                        'smtp_encryption' => 'Mail Server SMTP Transport Encryption protocol',
                        'smtp_from_address' => 'E-mail Sender From Address',
                        'smtp_from_name' => 'E-mail Sender From Name Displayed',
                        'bg_pattern_image' => 'Repeating background pattern image file',
                        default => '',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->limit(40)
                    ->formatStateUsing(fn ($record, $state) => $record->key === 'smtp_password' ? '********' : $state),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Actions\EditAction::make(),
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

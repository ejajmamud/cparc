<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Hall Packages';
    protected static \UnitEnum|string|null $navigationGroup = 'Bookings';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('English')->columns(2)->schema([
                Forms\Components\TextInput::make('name')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('duration_label')->label('Duration Label (e.g. 6 Hours)')->required(),
                Forms\Components\TextInput::make('price')->numeric()->prefix('৳')->required(),
                Forms\Components\Textarea::make('description')->rows(3),
                Forms\Components\Repeater::make('features')->label('Features (English)')->simple(
                    Forms\Components\TextInput::make('feature')
                )->columnSpanFull(),
            ]),
            Section::make('বাংলা (Bengali)')->columns(2)->schema([
                Forms\Components\TextInput::make('name_bn')->label('Name (Bengali)')->required(),
                Forms\Components\TextInput::make('duration_label_bn')->label('Duration (Bengali)')->required(),
                Forms\Components\Textarea::make('description_bn')->label('Description (Bengali)')->rows(3),
                Forms\Components\Repeater::make('features_bn')->label('Features (Bengali)')->simple(
                    Forms\Components\TextInput::make('feature')
                )->columnSpanFull(),
            ]),
            Section::make('Settings')->columns(3)->schema([
                Forms\Components\TextInput::make('duration_hours')->numeric()->required(),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_featured')->label('Featured (Most Popular)'),
                Forms\Components\Toggle::make('is_active')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name_bn')->label('নাম'),
                Tables\Columns\TextColumn::make('duration_label'),
                Tables\Columns\TextColumn::make('price')->money('BDT')->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('sort_order')->sortable()->label('Order'),
            ])
            ->reorderable('sort_order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit'   => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}

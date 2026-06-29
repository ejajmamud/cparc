<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';
    protected static \UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('English')->columns(2)->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('designation')->required(),
            ]),
            Section::make('বাংলা (Bengali)')->columns(2)->schema([
                Forms\Components\TextInput::make('name_bn')->label('Name (Bengali)'),
                Forms\Components\TextInput::make('designation_bn')->label('Designation (Bengali)'),
            ]),
            Section::make('Contact & Settings')->columns(3)->schema([
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('email')->email(),
                Forms\Components\Select::make('type')->options(['executive'=>'Executive Committee','former_president'=>'Former President','honorary'=>'Honorary'])->default('executive'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\FileUpload::make('photo')->image()->disk('public')->directory('members')->imageResizeMode('cover')->imageCropAspectRatio('3:4'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name_bn')->searchable()->label('নাম'),
                Tables\Columns\TextColumn::make('designation'),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('sort_order')->sortable()->label('Order'),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit'   => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}

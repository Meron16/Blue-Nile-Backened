<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use App\Models\RoomType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = RoomType::class;

    protected static ?string $navigationIcon = 'heroicon-o-building';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('room_type_id')
                    ->label('Room Type')
                    ->relationship('roomType', 'name')
                    ->required(),
                
                Forms\Components\TextInput::make('number')
                    ->label('Room Number')
                    ->required()
                    ->maxLength(10),
                
                Forms\Components\TextInput::make('floor')
                    ->required()
                    ->numeric(),
                
                Forms\Components\MultiSelect::make('amenities')
                    ->relationship('amenities', 'name')
                    ->columns(2)
                    ->placeholder('Select amenities'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('roomType.name')->label('Room Type')->sortable(),
                Tables\Columns\TextColumn::make('number')->sortable(),
                Tables\Columns\TextColumn::make('floor')->sortable(),
                Tables\Columns\TagsColumn::make('amenities.name')->label('Amenities'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}

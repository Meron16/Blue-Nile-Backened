<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'name')
                    ->required(),
                
                Forms\Components\DatePicker::make('check_in')
                    ->required(),
                
                Forms\Components\DatePicker::make('check_out')
                    ->required(),
                
                Forms\Components\TextInput::make('guest_name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('guest_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('guest_phone')
                    ->required()
                    ->maxLength(20),
                
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('room.name')->label('Room')->sortable(),
                Tables\Columns\TextColumn::make('guest_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('guest_email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('check_in')->date()->sortable(),
                Tables\Columns\TextColumn::make('check_out')->date()->sortable(),
                Tables\Columns\TextColumn::make('total_price')->money('usd'),
                Tables\Columns\TextColumn::make('status')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}

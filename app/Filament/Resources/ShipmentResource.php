<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Shipment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Infolists\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ShipmentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShipmentResource\RelationManagers;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('shipment_number')
                    ->label('Shipment Number')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('shipment_goods_name')
                    ->label('Goods Name')
                    ->required(),
                Forms\Components\TextInput::make('shipment_sender')
                    ->label('Sender')
                    ->required(),
                Forms\Components\TextInput::make('shipment_receiver')
                    ->label('Receiver')
                    ->required(),
                Forms\Components\TextInput::make('shipment_origin')
                    ->label('Origin')
                    ->required(),
                Forms\Components\TextInput::make('shipment_destination')
                    ->label('Destination')
                    ->required(),
            ])->columns(2);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Shipment Detail')
                            ->schema([
                                TextEntry::make('shipment_number')
                                    ->label('AWB Number'),
                                TextEntry::make('shipment_goods_name')
                                    ->label('Goods Name'),
                                TextEntry::make('shipment_sender')
                                    ->label('Sender'),
                                TextEntry::make('shipment_receiver')
                                    ->label('Receiver'),
                                TextEntry::make('shipment_origin')
                                    ->label('Origin'),
                                TextEntry::make('shipment_destination')
                                    ->label('Destination'),
                                TextEntry::make('user.name'),
                                TextEntry::make('latestHistory.shipment_status')
                                    ->label('Latest Shipment Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'on_process' => 'info',
                                        'delivered' => 'success',
                                        'on_transit' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'pending' => 'PENDING',
                                        'on_process' => 'ON PROCESS',
                                        'delivered' => 'DELIVERED',
                                        'on_transit' => 'ON TRANSIT',
                                        'cancelled' => 'CANCELLED',
                                        default => 'gray',
                                    }),
                                TextEntry::make('latestHistory.shipment_details')
                                    ->label('Latest Shipment Detail'),
                                TextEntry::make('latestHistory.created_at')
                                    ->label('Latest Shipment Status Update')
                                    ->dateTime(),
                            ])
                            ->columns(5),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('shipment_number')
                    ->label('AWB Number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipment_goods_name')
                    ->label('Goods Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipment_sender')
                    ->label('Sender'),
                Tables\Columns\TextColumn::make('shipment_receiver')
                    ->label('Receiver'),
                Tables\Columns\TextColumn::make('shipment_origin')
                    ->label('Origin'),
                Tables\Columns\TextColumn::make('shipment_destination')
                    ->label('Destination'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\ShipmentHistoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageShipments::route('/'),
            'view' => Pages\ViewShipment::route('/{record}'),
        ];
    }
}

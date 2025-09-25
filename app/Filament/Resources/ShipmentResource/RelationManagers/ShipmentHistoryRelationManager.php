<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use App\Models\Shipment;
use App\Models\ShipmentHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShipmentHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'histories';
    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('shipment_status')
                    ->options([
                        'pending' => 'Pending',
                        'on_process' => 'On Process',
                        'delivered' => 'Delivered',
                        'on_transit' => 'On Transit',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('shipment_details')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('shipment_status')
            ->modifyQueryUsing(fn($query) => $query->orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('shipment_status')
                    ->label('Shipment Status')
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
                Tables\Columns\TextColumn::make('shipment_details')
                    ->label('Shipment Details'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Updated At')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->color('success')
                    ->label('New Shipment History'),
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
}
<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

class ManageShipments extends ManageRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function(array $data){
                    $data['user_id'] = auth()->user()->id;
                    $data['shipmentId'] = Str::orderedUuid();
                    return $data;
                })
                ->successNotificationTitle('Shipment berhasil dibuat!')
                ->successRedirectUrl(fn ($record) => $this->getResource()::getUrl('view', ['record' => $record])),
        ];
    }
}

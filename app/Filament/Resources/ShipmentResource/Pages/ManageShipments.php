<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageShipments extends ManageRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function(array $data){
                    $data['user_id'] = auth()->user()->id;
                    return $data;
                })
                ->successRedirectUrl(fn ($record) => $this->getResource()::getUrl('view', ['record' => $record])),
        ];
    }
}

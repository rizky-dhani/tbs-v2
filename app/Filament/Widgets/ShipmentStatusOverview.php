<?php

namespace App\Filament\Widgets;

use App\Models\ShipmentHistory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShipmentStatusOverview extends BaseWidget
{
    protected static bool $isLazy = false;
    protected ?string $heading = 'Shipment Status';
    protected function getColumns(): int
    {
        return 4;
    }
    protected function getStats(): array
    {
        $shipmentStatuses = [
            'pending' => ['label' => 'Pending', 'color' => 'warning'],
            'on_process' => ['label' => 'On Process', 'color' => 'info'],
            'delivered' => ['label' => 'Delivered', 'color' => 'success'],
            'on_transit' => ['label' => 'On Transit', 'color' => 'primary'],
            'cancelled' => ['label' => 'Cancelled', 'color' => 'danger'],
        ];

        $stats = [];

        foreach ($shipmentStatuses as $shipmentStatus => $config) {
            // Get the count of shipments that have their latest history status matching the current status
            $count = \App\Models\Shipment::whereHas('latestHistory', function ($query) use ($shipmentStatus) {
                $query->where('shipment_status', $shipmentStatus);
            })->count();

            $stats[] = Stat::make($config['label'], $count)
                ->color($config['color'])
                ->url(route('filament.dashboard.resources.shipments.index', ['tableFilters[shipment_status][value]' => $shipmentStatus]));
        }

        return $stats;
    }
}
<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Shipment;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

class ShipmentDetail extends Component
{
    public $shipment, $shipmentId;
    public function mount($shipmentId)
    {
        $this->shipment = Shipment::with('histories')->where('shipmentId', $shipmentId)->first();
    }
    #[Layout('components.layouts.guest')]
    #[Title('Detail Pengiriman')]
    public function render()
    {
        return view('livewire.public.shipment-detail',[
            'shipmentDetail' => $this->shipment
        ]);
    }
}

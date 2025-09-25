<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use Livewire\Attributes\Title;

class ShipmentIndex extends Component
{
    public $search = '';
    #[Layout('components.layouts.guest')]
    #[Title('Shipment Search')]
    public function render()
    {
        $shipments = [];
        if(!empty($this->search)){
            $shipments = Shipment::with('histories')->where('shipment_number', $this->search)->get();
        }
        return view('livewire.public.shipment-index',[
            'shipment' => $shipments
        ]);
    }
}

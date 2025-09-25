<?php

use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Livewire\Public\ShipmentIndex;
use App\Livewire\Public\ShipmentDetail;

Route::get('/login', function(){
    return redirect('/dashboard/login');
});
Route::get('/tracking', ShipmentIndex::class)->name('shipments.public.search');
Route::get('/tracking/search/{shipmentId}', ShipmentDetail::class)->name('shipments.show');
<div>
    <div class="flex flex-col items-center">
        <!-- Card Container -->
        <div class="w-full max-w-[100%] mx-auto">
            <!-- Logo -->
            <div class="flex justify-center py-6">
                <div class="logo text-center">
                    <img src="{{ asset('images/logo-tbs_converted.webp') }}" alt="Logo" class="img-fluid max-w-[35%] mx-auto">
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl rounded-lg p-4 md:p-5">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('shipments.public.search') }}" class="btn btn-primary px-4">{{ __('Kembali') }}</a>
                </div>
                <!-- Title -->
                <h2 class="text-center mb-4 font-bold text-xl ">{{ __('Detail Pengiriman') }}</h2>
                <!-- Shipment Details -->
                <div class="mb-4 flex justify-center">
                    <div class="w-full max-w-[100%] md:max-w-[80%] lg:max-w-[60%]">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <!-- Left Details -->
                            <div class="md:ps-0 ps-3">
                                <div class="mb-2"><strong>Nomor Resi</strong> :
                                    {{ $shipmentDetail->shipment_number ?? '-' }}
                                </div>
                                <div class="mb-2"><strong>Nama Barang</strong> :
                                    {{ $shipmentDetail->shipment_goods_name ?? '-' }}</div>
                                <div class="mb-2"><strong>Pengirim</strong> :
                                    {{ $shipmentDetail->shipment_sender ?? '-' }}</div>
                                <div><strong>Penerima</strong> : {{ $shipmentDetail->shipment_receiver ?? '-' }}</div>
                            </div>
                            <!-- Right Details -->
                            <div class="md:ps-0 ps-3">
                                <div class="mb-2"><strong>Asal</strong> :
                                    {{ $shipmentDetail->shipment_origin ?? '-' }}</div>
                                <div class="mb-2"><strong>Tujuan</strong> :
                                    {{ $shipmentDetail->shipment_destination ?? '-' }}</div>
                                <div><strong>Status</strong> :
                                    @if ($shipmentDetail->histories->count() > 0)
                                        {{ ucwords(str_replace('_', ' ', $shipmentDetail->histories->last()->shipment_status)) }}
                                    @else
                                        {{ __('-') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Shipment History / Timeline -->
                <div class="mt-6">
                    <div class="w-full max-w-[100%] md:max-w-[80%] lg:max-w-[60%] mx-auto">
                        <h3 class="font-bold text-lg mb-4 text-center">{{ __('Riwayat Pengiriman') }}</h3>
                        <div class="overflow-x-auto">
                            <div class="flex flex-col space-y-4">
                                @forelse ($shipmentDetail->histories->sortByDesc('updated_at') as $index => $history)
                                    <div class="flex items-start p-4 bg-base-100 rounded-lg">
                                        <div class="flex-shrink-0 me-4">
                                            <i class="fa-solid fa-circle"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-base-content"><span class="font-bold">[{{ strtoupper(str_replace('_', ' ', $history->shipment_status)) }}]</span> {{ $history->shipment_details }}</div>
                                            <div class="text-sm opacity-70">{{ $history->updated_at->format('d M Y H:i') }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex items-center justify-center p-4 bg-base-100 rounded-lg">
                                        {{ __('Belum ada riwayat pengiriman') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

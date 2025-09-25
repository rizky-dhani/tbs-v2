<div class="flex flex-col min-h-screen">

    <!-- Main Content Section -->
    <div class="flex-grow flex items-center justify-center py-4">
        <div class="w-full max-w-2xl px-4">
            <!-- Logo Section -->
            <div class="flex justify-center py-6">
                <div class="logo text-center">
                    <img src="{{ asset('images/logo-tbs_converted.webp') }}" alt="Logo" class="img-fluid max-w-[35%] mx-auto">
                </div>
            </div>
            <!-- Search Card -->
            <div class="card bg-base-100 shadow-xl rounded-lg border border-base-200 p-6">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-base-content">{{ 'Lacak Pengiriman' }}</h1>
                </div>

                <form wire:submit.prevent="search" class="mb-6">
                    <div class="flex gap-2">
                        <input type="text" class="input input-bordered w-full" placeholder="Masukkan nomor resi"
                            wire:model.live.debounce.1000ms='search'>
                    </div>
                </form>

                <!-- Results Table -->
                @if (!empty($shipment))
                    <div class="overflow-x-auto">
                        <table class="table table-zebra table-sm md:table-md w-full">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('Nomor Resi') }}</th>
                                    <th class="text-center">{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shipment as $ship)
                                    <tr>
                                        <td class="text-center">{{ $ship->shipment_number }}</td>
                                        <td class="text-center">
                                            @if ($ship->histories->count() > 0)
                                                {{ ucwords(str_replace('_', ' ', $ship->histories->last()->shipment_status)) }}
                                            @else
                                                {{ __('-') }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('shipments.show', $ship->shipmentId) }}"
                                                class="btn btn-primary btn-sm">
                                                {{ __('Detail') }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            {{ __('Nomor resi tidak ditemukan. Mohon periksa kembali nomor resi yang anda masukkan') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

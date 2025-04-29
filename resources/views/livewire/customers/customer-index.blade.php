<div>
    <x-mary-header title="Customers" subtitle="Customers List">
        <x-slot:middle class="!justify-end">
            <x-mary-input type='search' icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
        </x-slot:actions>
    </x-mary-header>

    <div class="p-6 bg-white rounded">
        <table class="w-full">
            <thead class="font-bold">
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Payment</td>
                    <td>View</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="hover:bg-gray-100">
                        <td class="py-3">{{ $customer->id }}</td>
                        <td class="py-3">{{ $customer->name }}</td>
                        <td class="py-3">{{ $customer->email }}</td>
                        <td>
                            @if ($customer->payment)
                                @if ($customer->payment->status)
                                    <span class="text-green-700 px-2 py-1 rounded bg-green-100 text-sm">Approved</span>
                                @else
                                    <span class="text-yellow-700 px-2 py-1 rounded bg-yellow-200 text-sm">Pending</span>
                                @endif
                            @else
                                <span class="text-red-700 px-2 py-1 rounded bg-red-100 text-sm">No Payment</span>
                            @endif
                        </td>
                        <td>
                            @if ($customer->payment)
                                <x-mary-button class="btn-sm" icon="o-eye"
                                    wire:click="showPaymentDetails({{ $customer->payment->id }})" />
                            @endif
                        </td>
                        <td>
                            <x-mary-button icon="o-trash" wire:click="confirDelete({{ $customer->id }})"
                                class="btn-sm text-red-500" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>

    <x-mary-drawer wire:model="showDrawer" class="w-1/6 lg:w-1/4" right>
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">Payment Details</h2>
            @if ($selectedOrder)
                <div>
                    <img class="rounded h-100 w-100 mt-2" src="{{ asset('/receipts/' . $selectedOrder->receipt) }}" alt="">
                    <div>
                        <strong>Bank: </strong> {{ $selectedOrder->payment_via }}
                    </div>
                    @if ($selectedOrder->status)
                        <x-mary-button label="Approved" icon="o-check" class="bg-green-700 text-white"
                            wire:click="statusChange({{ $selectedOrder->id }}, 0)" />
                    @else
                        <x-mary-button label="Pending" icon="o-check" class="bg-yellow-500 text-white"
                            wire:click="statusChange({{ $selectedOrder->id }}, 1)" />
                    @endif
                </div>
            @else
                <p>No order selected.</p>
            @endif
        </div>
        <x-mary-button label="Close" @click="$wire.set('showDrawer', false)" />
    </x-mary-drawer>
</div>

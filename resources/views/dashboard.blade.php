<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="text-2xl font-bold"> {{ __('Dashboard') }}</div>
        <div  >
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-6">
                <x-mary-stat class="border " title="Categories" value="{{ $categoryCount }}" icon="o-envelope" description="Total Categories"  />

                <x-mary-stat class="border " title="Designs" description="Total Designs" value="{{ $designCount }}" icon="o-arrow-trending-up"
                     />

                <x-mary-stat class="border " title="Customers" description="Total Customers" value="{{ $customerCount }}" icon="o-users" />

                {{-- <x-mary-stat title="Downloads" description="This month" value="22" icon="o-arrow-trending-down"
                    class="text-orange-500" color="text-pink-500"  /> --}}

            </div>

        </div>
    </div>
</x-layouts.app>

<x-slot:sidebar  drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit   border-r-[1px]">
 
            {{-- BRAND --}}
            {{-- <div class="ml-5 pt-5">App</div> --}}
           
            {{-- MENU --}}
            <x-mary-menu activate-by-route>
 
                {{-- User --}}
                @if($user = auth()->user())
                    
 
                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions >
                            <x-mary-dropdown icon="o-power" class="btn-circle btn-ghost btn-xs"  tooltip-left="Logout">
                                <x-mary-menu-item icon="o-user" title="Profile" wire-navigate  link="/profile" />
                                <x-mary-menu-item icon="o-power" title="Logout"  wire-navigate link="/logout"/>
                            </x-mary-dropdown>
                            
                        </x-slot:actions>
                       
                    </x-mary-list-item>
                  
 
                    <x-mary-menu-separator />
                @endif
 
                <x-mary-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('dashboard') }}" />
                <x-mary-menu-item title="Customers" icon="o-users" link="{{ route('customers.index') }}" />
                <x-mary-menu-item title="Requests" icon="o-users" link="{{ route('requests.index') }}" />
                <x-mary-menu-sub title="Designs" icon="o-home">
                    <x-mary-menu-item title="Categories" icon="o-cog" wire:navigate link="{{ route('categories.index') }}" />
                    <x-mary-menu-item title="Designs" icon="o-home" wire:navigate link="{{ route('designs.index') }}" />

                </x-mary-menu-sub>

            </x-mary-menu>
        </x-slot:sidebar>
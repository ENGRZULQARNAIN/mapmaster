<div>
    <x-mary-header title="Designs" subtitle="Design List">
        <x-slot:middle class="!justify-end">


            <x-mary-input type='search' icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
            <x-mary-button @click="$wire.create()" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-modal wire:model="Modal">
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <x-mary-input wire:model="name" label="Design Name" placeholder="Enter design name" />
            </div>

            <div class="mb-4">
                <x-mary-input wire:model="marla" label="Marla" type="number" />
            </div>
            <div class="mb-4">
                <x-mary-input wire:model="no_of_rooms" label="Number of Rooms" type="number" />
            </div>
            <div class="mb-4">
                <x-mary-input wire:model="no_of_floors" label="Number of Floors" type="number" />
            </div>
            <div class="mb-4">
                <x-mary-input wire:model="price" label="Price" type="number" />
            </div>
            <div class="mb-4">
                <x-mary-textarea wire:model="description" label="Description" placeholder="Enter description" />
            </div>
            
            <div class="mb-4">
                <label for="">Type</label>
                <select wire:model="type" label="Design Type" class="w-full rounded border border-blue-700">
                    <option value="">Select Type</option>
                    <option value="2D">2D</option>
                    <option value="3D">3D</option>
                </select>

            </div>
            <div class="mb-4">

                <x-mary-select label="Category" placeholder="Select Category" icon-right="o-cog" :options="$categories"
                    wire:model="category_id" />

            </div>
            <div class="mb-4">
                <x-mary-file type="file" wire:model="thumbnail" label="Thumbnail" />
                <!-- Show preview for new uploads -->
                @if ($thumbnail && !is_string($thumbnail))
                    <img src="{{ $thumbnail->temporaryUrl() }}" class="h-40 rounded-lg mt-1" alt="Thumbnail Preview" />
                @elseif (is_string($thumbnail) && $design_id)
                    <img src="{{ Storage::url($thumbnail) }}" class="h-40 rounded-lg mt-1" alt="Existing Thumbnail" />
                @endif
            </div>
            <div class="flex justify-end">
                <x-mary-button type="submit" label="Save" class="btn-primary" spinner="save" />
                <x-mary-button label="Cancel" @click="modalClose()" class="ml-2" />
            </div>
        </form>
    </x-mary-modal>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
        @foreach ($designs as $design)
            <div class="border rounded-lg p-3 bg-white">
                <!-- Design image display -->
                <div class="mb-3">
                    @if($design->thumbnail)
                        <img src="{{ Storage::url($design->thumbnail) }}" 
                            alt="{{ $design->name }}"
                            class="w-full h-48 object-cover rounded-md"
                            onerror="this.onerror=null; this.src='{{ asset('storage/'.ltrim($design->thumbnail, 'public/')) }}'; console.log('Fallback to asset')">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>

                <h3 class="font-bold text-lg">{{ $design->name }}</h3>

                <div class="flex justify-between">
                    <p>Rooms:</p>
                    <p>{{ $design->no_of_rooms }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Floor:</p>
                    <p>{{ $design->no_of_floors }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Marla:</p>
                    <p>{{ $design->marla }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Type:</p>
                    <p>{{ $design->type }}</p>
                </div>
                <div class="flex justify-between">
                    <p>Price:</p>
                    <p>{{ $design->price }}</p>
                </div>

                <div class="flex justify-between">
                    <p>Category:</p>
                    <p><span class="bg-pink-500 px-3 py-1 rounded-lg text-white">{{ $design->category->name }}</span>
                    </p>
                </div>


                <!-- Action buttons -->
                <div class="mt-2">
                    <x-mary-button icon="o-pencil" wire:click="edit({{ $design->id }})"
                        class="btn-sm" />
                    <x-mary-button wire:confirm='are you sure?' icon="o-trash"
                        wire:click="delete({{ $design->id }})" class="btn-sm btn-error" />
                </div>
            </div>
        @endforeach
    </div>

</div>

<div>
    <x-mary-header title="Categories" subtitle="Categories">
        <x-slot:middle class="!justify-end">
            <x-mary-input type='search' icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" />
            <x-mary-button @click="$wire.Modal = true" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-modal wire:model="Modal" class="backdrop-blur">
       <div>
        <x-mary-form wire:submit="save">
            <x-mary-input label="Name"  wire:model="categoryName" />
         
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.Modal = false" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
       </div>
       
    </x-mary-modal>



    @php
    
 
    $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'name', 'label' => 'Category Name'],
        // ['key' => 'action', 'label' => 'Action'],
    ];
@endphp

<x-mary-table :headers="$headers" :rows="$categories" striped >
    @scope('actions', $category)
    <div class="flex gap-2">
        <x-mary-button icon="o-pencil" wire:click="edit({{ $category->id }})" class="btn-sm" />
            <x-mary-button icon="o-trash" wire:confirm='are you sure?' wire:click="delete({{ $category->id }})" spinner class="btn-sm" />
    </div>
            
    @endscope
</x-mary-table>

     
 
</div>

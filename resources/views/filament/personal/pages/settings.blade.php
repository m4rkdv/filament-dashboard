<x-filament-panels::page>

    <x-filament::section >
    <x-slot name="heading" class="mb-4">
        User details
    </x-slot>
    <div class="flex"> <!-- Contenedor con espacio entre los botones -->
            <x-filament::icon-button
                icon="heroicon-o-plus-circle"
                wire:click="increment"
                label="Increment"
                
            />

            <x-filament::badge color="gray" class="p-2 m-4">
                {{ $count }}
            </x-filament::badge>

            <x-filament::icon-button
                icon="heroicon-o-minus-circle"
                wire:click="decrement"
                label="Decrement"
                
            />
    </div>
     
    </x-filament::section>
       
    
</x-filament-panels::page>

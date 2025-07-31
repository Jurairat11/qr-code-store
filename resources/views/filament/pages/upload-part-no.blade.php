<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            {{ $this->form }}
        </div>

        <x-filament::button type="submit" class="mt-4">
            Upload
        </x-filament::button>
    </form>

</x-filament-panels::page>

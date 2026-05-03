<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="flex justify-end gap-3 mt-6">
            <x-filament::button type="submit" color="primary" size="lg">
                Сохранить
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>

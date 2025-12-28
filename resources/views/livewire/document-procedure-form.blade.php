<x-container>
    <form wire:submit.prevent="create">
        <div class=" flex justify-end mb-4">
            <button type="submit"
                class="px-4 py-1 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200 dark:bg-primary-500 dark:hover:bg-primary-600">
                Registrar
            </button>
        </div>
        {{ $this->form }}
    </form>
    <x-filament-actions::modals />
</x-container>

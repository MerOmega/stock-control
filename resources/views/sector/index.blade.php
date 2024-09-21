<x-layout title="{{  __('messages.sector.index.title') }}">

    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('sectors.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.sector.index.search.placeholder') }}"
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('sectors.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Reiniciar
            </a>
        </form>

        <a href="{{ route('sectors.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            <i class="fas fa-plus"></i>
            {{ __('messages.sector.index.create') }}
        </a>
    </div>

    <div class="space-y-6">
        @forelse($sectors as $sector)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden flex items-center">
                <div class="flex-1 block p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $sector->name }}
                    </h3>
                </div>
                <div class="p-4 flex space-x-4">
                    <a href="{{ route('sectors.edit', $sector->id) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button
                        onclick="openModal('delete-modal-{{ $sector->id }}', '{{ route('sectors.destroy', $sector->id) }}')"
                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <x-confirm-delete
                id="delete-modal-{{ $sector->id }}"
                title="{{ __('messages.sector.delete.title') }}"
                message="{{ __('messages.sector.delete.message', ['name' => $sector->name]) }}"
                confirmButtonText="Eliminar"
            />
        @empty
            <p class="text-gray-500 dark:text-gray-400">
                {{ __('messages.sector.index.search.not_found') }}
            </p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $sectors->links() }}
    </div>

</x-layout>

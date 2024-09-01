<x-layout title="Dispositivos">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('devices.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar dispositivo..."
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('devices.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Reiniciar
            </a>
        </form>

        <a href="{{ route('devices.selectType') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            <i class="fas fa-plus"></i> Nuevo Dispositivo
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse($devices as $device)
            <div
                class="flex flex-col justify-between h-full bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <a href="{{ route('devices.show', $device->id) }}" class="block p-6 flex-grow">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $device->sku }}
                    </h3>
                </a>
                <div class="p-4 flex justify-between">
                    <a href="{{ route('devices.edit', $device->id) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button
                        onclick="openModal('delete-modal-{{ $device->id }}', '{{ route('supplies.destroy', $device->id) }}')"
                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <x-confirm-delete
                id="delete-modal-{{ $device->id }}"
                title="Eliminar Insumo"
                message="¿Estás seguro de que deseas eliminar este insumo? Esta acción no se puede deshacer."
                confirmButtonText="Eliminar"
            />
        @empty
            <p class="text-gray-500 dark:text-gray-400 col-span-full">No se encontraron Insumos.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $devices->links() }}
    </div>
</x-layout>

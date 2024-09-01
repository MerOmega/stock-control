<x-layout title="Dispositivo - {{ $device->sku }}">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex justify-between pb-2">
            <a href="{{ route('devices.edit', $device->id) }}"
               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                <span>Editar Dispositivo</span>
            </a>

            <button
                onclick="openModal('delete-modal-{{ $device->id }}', '{{ route('devices.destroy', $device->id) }}')"
                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $device->sku }}</h1>
        <div class="mt-4">
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Sector actual:</strong> {{ $device->sector->name ?? 'Sin sector asignado'}}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Estado:</strong> {{ $device->state->label() ?? 'N/A' }}</p>
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Año de entrada:</strong> {{ $device->entry_year->format('d-m-Y') }}</p>
        </div>


        <div class="mt-6">
            <a href="{{ route('devices.index') }}" class="text-blue-500 dark:text-blue-300 hover:underline">
                Volver a lista de dispositivos
            </a>
        </div>
    </div>
    <x-confirm-delete
        id="delete-modal-{{ $device->id }}"
        title="Eliminar Insumo"
        message="¿Estás seguro de que deseas eliminar este insumo? Esta acción no se puede deshacer."
        confirmButtonText="Eliminar"
    />
</x-layout>

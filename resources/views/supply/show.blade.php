<x-layout title="Insumo - {{ $supply->name }}">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex justify-between pb-2">

            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $supply->name }}</h1>
            <button
                onclick="openModal('delete-modal-{{ $supply->id }}', '{{ route('supplies.destroy', $supply->id) }}')"
                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="flex flex-col">
            <a href="{{ route('supplies.edit', $supply->id) }}"
               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                <i class="fas fa-edit"></i>
                <span>Editar Insumo</span>
            </a>

            <a href="{{ route('supplies.records', $supply) }}"
               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600 pt-2">
                <i class="fas fa-receipt"></i>
                <span>Ver Historial</span>
            </a>
        </div>
        <div class="mt-4">
            <p class="text-gray-700 dark:text-gray-300">
                <strong>Categoría:</strong> {{ $supply->category->name ?? 'N/A' }}</p>
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Cantidad:</strong> {{ $supply->quantity }}</p>
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Descripción:</strong> {{ $supply->description }}
            </p>
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Observaciones:</strong> {{ $supply->observations }}
            </p>
        </div>


        <div class="mt-6">
            <a href="{{ route('supplies.index') }}" class="text-blue-500 dark:text-blue-300 hover:underline">
                Volver a Insumos
            </a>
        </div>
    </div>
    <x-confirm-delete
        id="delete-modal-{{ $supply->id }}"
        title="Eliminar Insumo"
        message="¿Estás seguro de que deseas eliminar este insumo? Esta acción no se puede deshacer."
        confirmButtonText="Eliminar"
    />
</x-layout>

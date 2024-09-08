<x-layout title="Dispositivo - {{ $device->sku }}">

    <div id="device-container" data-device-id="{{ $device->id }}" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <div class="flex justify-between pb-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $device->sku }}</h1>
            <button
                onclick="openModal('delete-modal-{{ $device->id }}', '{{ route('devices.destroy', $device->id) }}')"
                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="flex flex-col">
            <a href="{{ route('devices.edit', $device->id) }}"
               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                <i class="fas fa-edit"></i>
                <span>Editar Dispositivo</span>
            </a>
            <a href="{{ route('devices.records', $device->id) }}"
               class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600 pt-2">
                <i class="fas fa-receipt"></i>
                <span>Ver Historial</span>
            </a>
        </div>
        <div class="mt-4">
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Sector actual:</strong> {{ $device->sector->name ?? 'Sin sector asignado'}}</p>
            <p class="text-gray-700 dark:text-gray-300"><strong>Estado:</strong> {{ $device->state->label() ?? 'N/A' }}</p>
            <p class="text-gray-700 dark:text-gray-300 mt-2"><strong>Año de entrada:</strong> {{ $device->entry_year->format('d-m-Y') }}</p>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Insumos por Categoría</h2>
            @foreach($suppliesByCategory as $categoryName => $supplies)
                <div class="mt-4">
                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">{{ $categoryName }}</h3>
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-md shadow-md">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-left text-gray-600 dark:text-gray-400">Insumos</th>
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-center text-gray-600 dark:text-gray-400">Cantidad</th>
                            <th class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-center text-gray-600 dark:text-gray-400">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supplies as $supply)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                                    <a href="{{ route('supplies.show', $supply) }}" target="_blank">
                                        {{ $supply->name }}
                                        <i class="fas fa-external-link-alt text-xs ml-1"></i>
                                    </a>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-center text-gray-700 dark:text-gray-300">
                                    <input type="number" id="quantity-{{ $supply->id }}" value="{{ $supply->pivot->quantity }}" class="w-16 text-center rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300 dark:border-gray-600 text-center">
                                    <button type="button" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700 remove-supply" data-device-id="{{ $device->id }}" data-supply-id="{{ $supply->id }}">Eliminar</button>
                                    <button type="button" class="bg-green-600 text-white px-2 py-1 rounded-md hover:bg-green-700 update-supply" data-device-id="{{ $device->id }}" data-supply-id="{{ $supply->id }}" data-action="change">Modificar</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Agregar Insumo</h2>

            <div id="supply-fields" class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="text" id="supply-search" placeholder="Buscar insumo..." class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100" autocomplete="off">
                    <input type="number" id="supply-quantity" placeholder="Cantidad" class="block w-24 rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                    <button type="button" id="add-supply" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Agregar</button>
                </div>
                <ul id="supplies-list" class="mt-2 bg-white border border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md"></ul>
            </div>

            <!-- Supplies list to be submitted -->
            <ul id="supplies-selected-list" class="mt-4 space-y-2"></ul>
        </div>

        <!-- Save Button -->
        <div class="mt-6">
            <button type="button" id="save-device" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Guardar Dispositivo</button>
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

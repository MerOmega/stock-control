<x-layout title="Dispositivos">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-4 space-y-4 lg:space-y-0 lg:space-x-4">
        <form method="GET" action="{{ route('devices.index') }}" class="w-full lg:w-auto flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar dispositivo..."
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">

            <select name="sector_id"
                    class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">
                <option value="">Todos los sectores</option>
                @foreach($sectors as $sector)
                    <option value="{{ $sector->id }}" {{ $sector->id == $selectedSector ? 'selected' : '' }}>
                        {{ $sector->name }}
                    </option>
                @endforeach
            </select>

            <select name="state"
                    class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">
                <option value="">Todos los estados</option>
                @foreach(App\State::cases() as $state)
                    <option value="{{ $state->value }}" {{ $state->value == $selectedState ? 'selected' : '' }}>
                        {{ $state->label() }}
                    </option>
                @endforeach
            </select>

            <select name="type"
                    class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">
                <option value="">Todos los tipos</option>
                @foreach(App\Http\Controllers\DeviceController::$deviceTypes as $key => $value)
                    <option value="{{ $key }}" {{ $key == $selectedType ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <div class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full lg:w-auto">
                    Buscar
                </button>
                <a href="{{ route('devices.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full lg:w-auto text-center">
                    Reiniciar
                </a>
            </div>
        </form>

        <a href="{{ route('devices.selectType') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 w-full lg:w-auto text-center">
            <i class="fas fa-plus"></i> Nuevo Dispositivo
        </a>
    </div>


    @if($devices->total() > 0)
        <div class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-4 rounded-md">
            <span class="font-semibold">Dispositivos Totales:</span> {{ $devices->total() }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse($devices as $device)
            <div
                class="flex flex-col justify-between h-full bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <a href="{{ route('devices.show', $device->id) }}" class="block p-6 flex-grow">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $device->deviceable->getLabel() }} - {{ $device->sku }}
                    </h3>
                </a>
                <div class="p-4 flex justify-between">
                    <a href="{{ route('devices.edit', $device) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{ route('devices.records', $device) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-receipt"></i>
                    </a>

                    <button
                        onclick="openModal('delete-modal-{{ $device->id }}', '{{ route('devices.destroy', $device) }}')"
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

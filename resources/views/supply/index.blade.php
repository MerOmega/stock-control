<x-layout title="Insumos">
    <div class="flex flex-col lg:flex-row justify-between items-center mb-4 space-y-4 lg:space-y-0">
        <form method="GET" action="{{ route('supplies.index') }}" class="w-full lg:w-auto flex flex-col lg:flex-row items-center space-y-4 lg:space-x-2 lg:space-y-0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar insumo..."
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">

            <select name="category_id"
                    class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2 w-full lg:w-auto">
                <option value="">Todas las Categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex flex-col lg:flex-row lg:space-x-4 w-full lg:w-auto">
                <div class="flex items-center">
                    <input type="checkbox" name="low_stock" id="low_stock" value="1"
                           class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                        {{ request('low_stock') || old('low_stock', $lowStockSearch) ? 'checked' : '' }}>
                    <label for="low_stock" class="ml-2 text-gray-700 dark:text-gray-300 font-medium">Stock Bajo</label>
                </div>

                <div class="flex items-center mt-2 lg:mt-0">
                    <input type="checkbox" name="no_stock" id="no_stock" value="1"
                           class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out"
                        {{ request('no_stock') || old('no_stock', $noStockSearch) ? 'checked' : '' }}>
                    <label for="no_stock" class="ml-2 text-gray-700 dark:text-gray-300 font-medium">Sin Stock</label>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row items-center space-y-4 lg:space-y-0 lg:space-x-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full lg:w-auto">
                    Buscar
                </button>
                <a href="{{ route('supplies.index') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full lg:w-auto text-center">
                    Reiniciar
                </a>
            </div>
        </form>

        <a href="{{ route('supplies.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 w-full lg:w-auto text-center">
            <i class="fas fa-plus"></i> Nuevo Insumo
        </a>
    </div>

    @if($supplies->total() > 0)
        <div class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 p-4 rounded-md">
            <span class="font-semibold">Insumos totales:</span> {{ $supplies->total() }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse($supplies as $supply)
            <div
                class="flex flex-col justify-between h-full bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <a href="{{ route('supplies.show', $supply->id) }}" class="block p-6 flex-grow">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $supply->name }}
                    </h3>
                    <span class="mt-2 block text-base font-normal text-gray-600 dark:text-gray-400">
                        {{ Str::limit($supply->description, 50) ?? 'Sin descripción' }}
                    </span>
                    <p class="pt-6 flex flex-col">
                        @if($supply->quantity == 0)
                            <span class="text-red-600 dark:text-red-400">
                                 <i class="fas fa-exclamation-triangle"></i> Sin Stock
                            </span>
                        @elseif($supply->quantity <= $lowStock)
                            <span class="text-yellow-500 dark:text-yellow-400">
                             <i class="fas fa-exclamation-circle"></i> Stock Bajo
                         </span>
                        @endif
                        <span>Quantity: {{ $supply->quantity }}</span>
                    </p>
                </a>
                <div class="p-4 flex justify-between">
                    <a href="{{ route('supplies.edit', $supply->id) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="{{ route('supplies.records', $supply) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-receipt"></i>
                    </a>

                    <button
                        onclick="openModal('delete-modal-{{ $supply->id }}', '{{ route('supplies.destroy', $supply->id) }}')"
                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <x-confirm-delete
                id="delete-modal-{{ $supply->id }}"
                title="Eliminar Insumo"
                message="¿Estás seguro de que deseas eliminar este insumo? Esta acción no se puede deshacer."
                confirmButtonText="Eliminar"
            />
        @empty
            <p class="text-gray-500 dark:text-gray-400 col-span-full">No se encontraron Insumos.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $supplies->links() }}
    </div>
</x-layout>

<x-layout title="Insumos">
    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('supplies.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar insumo..."
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2">

            <select name="category_id"
                    class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2">
                <option value="">Todas las Categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $selectedCategory ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('supplies.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Reiniciar
            </a>
        </form>

        <a href="{{ route('supplies.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            <i class="fas fa-plus"></i> Nuevo Insumo
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse($supplies as $supply)
            <div
                class="flex flex-col justify-between h-full bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <a href="{{ route('supplies.show', $supply->id) }}" class="block p-6 flex-grow">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $supply->name }}
                    </h3>
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

<x-layout title="Categoría">

    <div class="flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('categories.index') }}" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar categoría..."
                   class="rounded-md border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-indigo-600 dark:focus:ring-indigo-500 px-4 py-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Buscar
            </button>
            <a href="{{ route('categories.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Reiniciar
            </a>
        </form>

        <a href="{{ route('categories.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            <i class="fas fa-plus"></i> Nueva Categoría
        </a>
    </div>

    <div class="space-y-6">
        @forelse($categories as $category)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden flex items-center">
                <div class="flex-1 block p-6">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ $category->name }}
                    </h3>
                </div>
                <div class="p-4 flex space-x-4">
                    <a href="{{ route('categories.edit', $category->id) }}"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </a>

                    <button
                        onclick="openModal('delete-modal-{{ $category->id }}', '{{ route('categories.destroy', $category->id) }}')"
                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <x-confirm-delete
                id="delete-modal-{{ $category->id }}"
                title="Eliminar Categoría"
                message="¿Estás seguro de que deseas eliminar esta categoría? Esta acción no se puede deshacer."
                confirmButtonText="Eliminar"
            />
        @empty
            <p class="text-gray-500 dark:text-gray-400">No se encontraron categorías.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $categories->links() }}
    </div>

</x-layout>

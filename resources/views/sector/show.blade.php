<x-layout title="Categoría - {{ $category->name }}">

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $category->name }}</h1>

        <div class="mt-4">
            <a href="{{ route('categories.index') }}" class="text-blue-500 dark:text-blue-300 hover:underline">
                Back to categories
            </a>
        </div>
    </div>

</x-layout>

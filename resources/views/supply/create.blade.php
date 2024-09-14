<x-layout title="Crear Insumo">
    <x-submit-error/>
    <form method="POST" action="{{ route('supplies.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <div class="col-span-full">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Nombre
                    </label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" autocomplete="category" required
                               class="block pl-1 w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    </div>
                </div>
                {{-- Category field --}}
                <div class="col-span-full">
                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Categoría
                    </label>
                    <div class="mt-2">
                        <select name="category_id" id="category_id" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- End category field --}}

                {{-- Quantity field --}}
                <div class="col-span-full">
                    <label for="quantity" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Cantidad
                    </label>
                    <div class="mt-2">
                        <input type="number" name="quantity" id="quantity" autocomplete="1" required
                               class="block pl-1 w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    </div>
                </div>
                {{-- End quantity field --}}

                {{-- Description field --}}
                <div class="col-span-full">
                    <label for="description"
                           class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Descripción
                    </label>
                    <div class="mt-2">
                        <textarea name="description" id="description" placeholder="Descripción..."
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
                {{-- End description field --}}

                {{-- Observations field --}}
                <div class="col-span-full">
                    <label for="observations"
                           class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Observaciones
                    </label>
                    <div class="mt-2">
                        <textarea name="observations" id="observations" placeholder="Observaciones..."
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
                {{-- End observations field --}}

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('supplies.index') }}"
                       class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">Cancel</a>
                    <button type="submit"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>

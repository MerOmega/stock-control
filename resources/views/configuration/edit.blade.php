<x-layout title="{{ __('messages.configuration.update.title') }}">

    <form action="{{ route('configurations.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Low Stock Alert Field -->
        <div class="mb-4">
            <label for="low_stock_alert" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                {{ __('messages.configuration.update.fields.low_stock_alert') }}
            </label>
            <input type="number" name="low_stock_alert" id="low_stock_alert" required
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100"
                   value="{{ old('low_stock_alert', $configuration->low_stock_alert) }}">
            @error('low_stock_alert')
            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Default Items Per Page Field -->
        <div class="mb-4">
            <label for="default_per_page" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                {{ __('messages.configuration.update.fields.default_items_per_page') }}
            </label>
            <input type="number" name="default_per_page" id="default_per_page" required
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100"
                   value="{{ old('default_per_page', $configuration->default_per_page) }}">
            @error('default_per_page')
            <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 dark:hover:bg-blue-600">
            {{ __('messages.configuration.update.submit') }}
        </button>
    </form>

</x-layout>

<x-layout title="Select Device Type">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Select Device Type</h1>

        <form method="GET" action="{{ route('devices.create') }}">
            <select name="type" id="device-type" class="mb-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                @foreach($deviceTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Next
            </button>
        </form>
    </div>
</x-layout>

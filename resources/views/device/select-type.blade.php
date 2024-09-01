<x-layout title="Select Device Type">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Select Device Type</h1>

        <form method="GET" action="{{ route('devices.create') }}">
            <select name="type" id="device-type" class="block w-full p-2 border rounded mb-4">
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

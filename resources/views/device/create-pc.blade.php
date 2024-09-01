<x-layout title="Crear PC">
    <x-submit-error/>
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <x-device-fields field="pc"/>

                <div class="col-span-full">
                    <label for="sector_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Sector
                    </label>
                    <div class="mt-2">
                        <select name="sector_id" id="sector_id" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('devices.index') }}"
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

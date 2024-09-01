<x-layout title="Crear Monitor">
    <x-submit-error/>
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <x-device-fields field="monitor"/>

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

                <div class="col-span-full mt-6">
                    <label for="has_vga" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Tiene VGA
                    </label>
                    <div class="mt-2">
                        <input type="checkbox" name="has_vga" id="has_vga" value="1"
                               class="rounded text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500">
                    </div>
                </div>

                <div class="col-span-full mt-4">
                    <label for="has_dp" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Tiene DisplayPort
                    </label>
                    <div class="mt-2">
                        <input type="checkbox" name="has_dp" id="has_dp" value="1"
                               class="rounded text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500">
                    </div>
                </div>

                <div class="col-span-full mt-4">
                    <label for="has_hdmi" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Tiene HDMI
                    </label>
                    <div class="mt-2">
                        <input type="checkbox" name="has_hdmi" id="has_hdmi" value="1"
                               class="rounded text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-500">
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

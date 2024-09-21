<x-layout title="Crear Monitor">
    <x-submit-error/>
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <x-device-fields field="monitor" :sectors="$sectors"/>

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

<x-layout title="Crear otro dispositivo">
    <x-submit-error/>
    <form method="POST" action="{{ route('devices.store') }}">
        @csrf
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <x-device-fields field="OtherDevice" :sectors="$sectors"/>

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

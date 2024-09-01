@php use App\Models\Monitor; @endphp
<x-layout title="Editar Dispositivo - {{ $device->sku }}">

    <x-submit-error/>

    <form method="POST" action="{{ route('devices.update', $device->id) }}">
        @csrf
        @method('PUT')
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                {{-- SKU Field --}}
                <div class="col-span-full">
                    <label for="sku" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        SKU
                    </label>
                    <div class="mt-2">
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $device->sku) }}" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    </div>
                </div>

                {{-- Sector Field --}}
                <div class="col-span-full mt-6">
                    <label for="state" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Sector
                    </label>
                    <div class="mt-2">
                        <select name="sector" id="sector" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-span-full mt-6">
                    <label for="state" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        State
                    </label>
                    <div class="mt-2">
                        <select name="state" id="state" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            @foreach(App\State::cases() as $state)
                                <option value="{{ $state->value }}" {{ old('state', $device->state) == $state->value ? 'selected' : '' }}>
                                    {{ $state->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="entry_year" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Año de Ingreso
                    </label>
                    <div class="mt-2">
                        <input type="date" name="entry_year" id="entry_year" value="{{ old('entry_year', $device->entry_year->format('Y-m-d')) }}" required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    </div>
                </div>

                @if ($device->deviceable_type === Monitor::class)
                    {{-- Additional Monitor-Specific Fields --}}
                    <div class="col-span-full">
                        <label for="has_hdmi" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                            HDMI Support
                        </label>
                        <div class="mt-2">
                            <input type="checkbox" name="has_hdmi" id="has_hdmi" {{ $device->deviceable->has_hdmi ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="has_vga" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                            VGA Support
                        </label>
                        <div class="mt-2">
                            <input type="checkbox" name="has_vga" id="has_vga" {{ $device->deviceable->has_vga ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="has_dp" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
                            DisplayPort Support
                        </label>
                        <div class="mt-2">
                            <input type="checkbox" name="has_dp" id="has_dp" {{ $device->deviceable->has_dp ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </div>
                @endif
                {{-- Action Buttons --}}
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

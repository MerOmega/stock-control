@props(['field', 'sectors'])

<input type="hidden" name="type" value="{{ $field }}">


{{-- SKU Field --}}
<div class="col-span-full">
    <label for="sku" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
        SKU
    </label>
    <div class="mt-2">
        <input type="text" name="sku" id="sku" required autocomplete="off"
        class="block w-full pl-1 rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
    </div>
</div>

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

{{-- Entry Year Field --}}
<div class="col-span-full">
    <label for="entry_year" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
        Año de Ingreso
    </label>
    <div class="mt-2">
        <input type="date" name="entry_year" id="entry_year" required value="{{ now()->format('Y-m-d') }}"
               class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6 appearance-none cursor-pointer">
    </div>
</div>

{{-- State Field --}}
<div class="col-span-full">
    <label for="state" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
        Estado
    </label>
    <div class="mt-2">
        <select name="state" id="state" required
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
            @foreach(App\State::cases() as $state)
                <option value="{{ $state->value }}">{{ $state->label() }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- Description field --}}
<div class="col-span-full">
    <label for="description"
           class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">
        Descripción
    </label>
    <div class="mt-2">
                        <textarea name="description" id="description" placeholder="Descripción..."
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 bg-white
                                  dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400
                                  dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500
                                  sm:text-sm sm:leading-6">

                        </textarea>
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
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100
                                  bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600
                                  placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset
                                  focus:ring-indigo-600 dark:focus:ring-indigo-500 sm:text-sm sm:leading-6">
                        </textarea>
    </div>
</div>

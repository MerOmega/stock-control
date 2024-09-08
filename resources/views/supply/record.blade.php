@php
    use App\State;
@endphp
<x-layout title="Historial de Registros del Dispositivo">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
            Historial de {{ $supply->name }}
        </h1>

        <a href="{{ route('supplies.show', $supply->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Volver al Insumo {{ $supply->name }}
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Fecha</th>
                <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Descripción</th>
                <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Cambios</th>
            </tr>
            </thead>
            <tbody>
            @forelse($records as $record)
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $record->created_at->format('d/m/Y H:i') }}</td>

                    <!-- Display the message -->
                    <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                        {{ json_decode($record->data)->message ?? 'Sin mensaje' }}
                    </td>

                    <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                        @php
                            $data = json_decode($record->data);
                        @endphp

                        @if(isset($data->changes) && is_array($data->changes))
                            <ul>
                                @foreach($data->changes as $change)
                                    @php
                                            $oldLabel = $change->oldValue;
                                            $newLabel = $change->newValue;
                                    @endphp
                                    <li>
                                        <strong>{{ $change->key }}:</strong>
                                        {{ $oldLabel }} → {{ $newLabel }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            Sin cambios
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">
                        No hay registros disponibles para este dispositivo.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    @if($records->isNotEmpty())
        <div class="mt-8">
            {{ $records->links() }}
        </div>
    @endif
</x-layout>

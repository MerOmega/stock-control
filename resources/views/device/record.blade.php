@php
    use App\State; // Adjust namespace if needed
@endphp
<x-layout title="Historial de Registros del Dispositivo">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
            Historial de {{ $device->sku }}
        </h1>

        <a href="{{ route('devices.show', $device->id) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Volver al dispositivo {{ $device->sku }}
        </a>
    </div>

    <!-- Device Record Table -->
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

                    <!-- Display changes if they exist -->
                    <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                        @php
                            $data = json_decode($record->data);
                        @endphp

                        @if(isset($data->changes) && is_array($data->changes))
                            <ul>
                                @foreach($data->changes as $change)
                                    @php
                                        // Check if the change is for the 'state' key
                                        if ($change->key === 'state') {
                                            // Map the old and new values to the enum's labels
                                            $oldLabel = State::from($change->oldValue)->label();
                                            $newLabel = State::from($change->newValue)->label();
                                        } else {
                                            $oldLabel = $change->oldValue;
                                            $newLabel = $change->newValue;
                                        }
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

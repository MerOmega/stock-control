<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <script>
        function toggleTheme() {
            const htmlElement = document.documentElement;
            const currentTheme = htmlElement.classList.contains('dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.classList.toggle('dark', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.classList.toggle('dark', savedTheme === 'dark');
            }
        });
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
<div class="min-h-full">
    @php
        $links = [
            ['url' => '/', 'text' => 'Inicio', 'active' => request()->routeIs('dashboard')],
            ['url' => '/categories', 'text' => 'Categorias', 'active' => request()->routeIs('categories.index')],
            ['url' => '/sectors', 'text' => 'Sectores', 'active' => request()->routeIs('sectors.index')],
            ['url' => '/supplies', 'text' => 'Insumos', 'active' => request()->routeIs('supplies.index')],
            ['url' => '/devices', 'text' => 'Dispositivos', 'active' => request()->routeIs('devices.index')],
            ['url' => '/configurations/edit', 'text' => 'Configuracion', 'active' => request()->routeIs('configurations.edit')],
        ];
    @endphp

    <x-navbar :links="$links"/>

    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">{{ $title }}</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-4 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            {{ $slot }}
        </div>
    </main>
</div>

<!-- Theme Toggle Button for Testing -->
<div class="fixed bottom-4 right-4">
    <button onclick="toggleTheme()"
            class="bg-gray-800 text-white dark:bg-gray-200 dark:text-gray-800 px-4 py-2 rounded-md">
        Toggle Theme
    </button>
</div>
</body>
</html>

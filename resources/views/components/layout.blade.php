<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<div class="min-h-full">
    @php
        $links = [
            ['url' => '/', 'text' => 'Inicio', 'active' => request()->routeIs('dashboard')],
            ['url' => '/categories', 'text' => 'Categorias', 'active' => request()->routeIs('categories.index')],
            ['url' => '/supply', 'text' => 'Insumos', 'active' => request()->routeIs('projects')],
            ['url' => '/devices', 'text' => 'Dispositivos', 'active' => request()->routeIs('calendar')],
        ];
    @endphp

    <x-navbar :links="$links" />

    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
        </div>
    </header>
    <main >
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 ">
            {{ $slot }}
        </div>
    </main>
</div>
</html>

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Procesador',
            'Placa madre',
            'Memoria RAM',
            'Disco',
            'Fuente',
            'Placa Wi-Fi',
            'Placa Ethernet',
            'Placa de video',
            'Pila',
            'Teclado',
            'Mouse',
            'Parlantes',
            'Auriculares',
            'Cámara',
            'Micrófono',
            'Estabilizador/UPS',
        ];

        foreach ($categories as $category) {
            Category::factory()->create(['name' => $category]);
        }
    }
}

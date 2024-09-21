<?php

return [
    'root'          => [
        'toggle_theme' => 'Cambiar tema',
    ],
    'supply'        => [
        'index'            => [
            'title' => 'Insumos',
        ],
        'supply_not_found' => 'Insumo no encontrado.',
        'supply_created'   => 'Insumo creado!',
        'supply_updated'   => 'Insumo actualizado!',
        'supply_deleted'   => 'Insumo eliminado!',
    ],
    'device'        => [
        'index'            => [
            'title' => 'Dispositivos',
        ],
        'nav'              => [
            'title' => 'Dispositivos',
        ],
        'show'             => [
            'title'           => 'Dispositivo',
            'no_description'  => 'Sin descripción',
            'no_observations' => 'Sin observaciones',
        ],
        'device_not_found' => 'Dispositivo no encontrado.',
        'device_created'   => 'Dispositivo creado!',
        'device_updated'   => 'Dispositivo actualizado!',
        'device_deleted'   => 'Dispositivo eliminado!',
        'supply_not_found' => 'Insumo no encontrado en este dispositivo.',
        'type'             => [
            'PC'      => 'PC',
            'Monitor' => 'Monitor',
            'Printer' => 'Impresora',
            'Other'   => 'Otro',
        ]
    ],
    'sector'        => [
        'index'            => [
            'title'  => 'Lugares',
            'create' => 'Crear lugar',
            'search' => [
                'placeholder' => 'Buscar lugar...',
                'button'      => 'Buscar',
                'not_found'   => 'No se encontraron lugares...',
            ],
        ],
        'create'           => [
            'title'  => 'Crear lugar',
            'fields' => [
                'name' => 'Nombre',
            ],
            'cancel' => 'Cancelar',
            'submit' => 'Crear lugar',
        ],
        'delete'           => [
            'title'   => 'Eliminar lugar',
            'message' => 'Estás seguro de que deseas eliminar :name? Esta acción no se puede deshacer.',
        ],
        'update'           => [
            'title' => 'Editar lugar',
        ],
        'nav'              => [
            'title' => 'Lugares',
        ],
        'sector_not_found' => 'Lugar no encontrado.',
        'sector_created'   => 'Lugar creado!',
        'sector_updated'   => 'Lugar actualizado!',
        'sector_deleted'   => 'Lugar eliminado!',
    ],
    'category'      => [
        'index'              => [
            'title' => 'Categorías',
        ],
        'update'             => [
            'title' => 'Editar categoría',
        ],
        'nav'                => [
            'title' => 'Categorías',
        ],
        'category_not_found' => 'Categoría no encontrada.',
        'category_created'   => 'Categoría creada!',
        'category_updated'   => 'Categoría actualizada!',
        'category_deleted'   => 'Categoría eliminada!',
    ],
    'configuration' => [
        'index'                 => [
            'title' => 'Configuración',
        ],
        'update'                => [
            'title'  => 'Editar configuración',
            'fields' => [
                'low_stock_alert'        => 'Alerta de stock bajo',
                'default_items_per_page' => 'Items por default por página',
            ],
            'submit' => 'Guardar configuración',
        ],
        'nav'                   => [
            'title' => 'Configuración',
        ],
        'configuration_updated' => 'Configuración actualizada!',
    ],

];

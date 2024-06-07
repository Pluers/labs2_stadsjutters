<?php

return [
    'name' => 'Stadsjutters',
    'manifest' => [
        'name' => env('APP_NAME', 'Stadsjutters App'),
        'short_name' => 'Stadsjutters',
        'start_url' => '/',
        'background_color' => '#f9f1f2',
        'theme_color' => '#8b5a5f',
        'display' => 'standalone',
        'orientation'=> 'portrait',
        'status_bar'=> '#8b5a5f',
        'icons' => [
            '512x512' => [
                'path' => '/public/favicon.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/public/maskable_icon.png',
                'purpose' => 'any maskable'
            ],
        ],
        'splash' => [
            '640x1136' => '/public/favicon.png',
            '750x1334' => '/public/favicon.png',
            '828x1792' => '/public/favicon.png',
            '1125x2436' => '/public/favicon.png',
            '1242x2208' => '/public/favicon.png',
            '1242x2688' => '/public/favicon.png',
            '1536x2048' => '/public/favicon.png',
            '1668x2224' => '/public/favicon.png',
            '1668x2388' => '/public/favicon.png',
            '2048x2732' => '/public/favicon.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Shortcut Link 1',
                'description' => 'Shortcut Link 1 Description',
                'url' => '/shortcutlink1',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Shortcut Link 2',
                'description' => 'Shortcut Link 2 Description',
                'url' => '/shortcutlink2'
            ]
        ],
        'custom' => []
    ]
];

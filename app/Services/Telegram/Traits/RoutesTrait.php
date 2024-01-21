<?php

namespace App\Services\Telegram\Traits;

use App\Services\Telegram\Screens\StartScreen;

trait RoutesTrait
{

    private array $routes = [
        [
            'keys' => [
                '/start',
                '/menu',
            ],
            'class' => StartScreen::class,
        ]
    ];

    private function getRoutes(): array
    {
        return $this->routes;
    }

}

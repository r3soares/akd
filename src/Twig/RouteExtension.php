<?php

namespace App\Twig;

use App\Routes\RouteName;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('route', [$this, 'getRouteName']),
        ];
    }

    public function getRouteName(string $name): string
    {
        return constant(RouteName::class . '::' . $name);
    }
}

<?php

namespace App\Service;

use App\Routes\RouteName;

class NavService
{
    private array $roleRoutes = [
        'ROLE_USER' => [
            'Home' => RouteName::USER_HOME,
            'Perfil' => RouteName::USER_PERFIL,
            'Cronograma' => RouteName::USER_SCHEDULE,
            'Meus Treinos' => RouteName::USER_SCHEDULE,
        ],
        'ROLE_MANAGER' => [
            'Home' => RouteName::MANAGER_HOME,
        ],
        'ROLE_ADMIN' => [
            'Home' => RouteName::ADMIN,
        ],
    ];

    private array $homeRoleRoute = [
        'ROLE_USER' => RouteName::USER_HOME,
        'ROLE_MANAGER' => RouteName::MANAGER_HOME,
        'ROLE_ADMIN' => RouteName::USER_HOME,
    ];

    public function getRoleNames() {
        return [
            'ROLE_USER' => 'Aluno',
            'ROLE_MANAGER' => 'Treinador',
            'ROLE_ADMIN' => 'Administrador',
        ];
    }
    public function getRoutesForRole(string $role): array
    {
        return $this->roleRoutes[$role] ?? [];
    }

    public function getHomeRoleRoute(string $role): string
    {
        return $this->homeRoleRoute[$role] ?? '';
    }
}

<?php

namespace App\Service;

class NavService
{
    private array $roleRoutes = [
        'ROLE_USER' => [
            'Home' => 'user_home',
            'Perfil' => 'user_perfil',
            'Cronograma' => 'user_schedule',
            'Meus Treinos' => 'user_workout',
        ],
        'ROLE_MANAGER' => [
            'Home' => 'manager_home',
        ],
        'ROLE_ADMIN' => [
            'Home' => 'admin',
        ],
    ];

    private array $homeRoleRoute = [
        'ROLE_USER' => 'user_home',
        'ROLE_MANAGER' => 'manager_home',
        'ROLE_ADMIN' => 'admin',
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

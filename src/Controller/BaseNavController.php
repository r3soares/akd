<?php

namespace App\Controller;

use App\Routes\RouteName;
use App\Service\NavService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nav')]
final class BaseNavController extends AbstractController
{
    public function __construct(private NavService $navService) {}
    #[Route('', RouteName::APP_NAV)]
    public function index(Request $request, SessionInterface $session): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->visitor();
        }

        // Role ativa no session
        $activeRole = $session->get('active_role', 'ROLE_USER');

        // Se não tiver role ativa, usar a primeira role do usuário
        if (!$activeRole) {
            $roles = $user->getRoles(); // Ex: ['ROLE_ADMIN', 'ROLE_USER']
            $activeRole = $roles[0];
            $session->set('active_role', $activeRole);
        }

        // Rotas disponíveis para a role ativa
        $routes = $this->navService->getRoutesForRole($activeRole);

        // Roles disponíveis para troca (para dropdown)
        $switchableRoles = $user->getRoles();

        return $this->render('nav/home.html.twig', [
            'routes' => $routes,
            'activeRole' => $activeRole,
            'switchableRoles' => $switchableRoles,
            'roleNames' => $this->navService->getRoleNames()
        ]);
    }

    #[Route('/switch-role/{role}', name: RouteName::APP_SWITCH_ROLE)]
    public function switchRole(string $role, SessionInterface $session): Response
    {
        $userRoles = $this->getUser()->getRoles();

        if (!in_array($role, $userRoles)) {
            throw $this->createAccessDeniedException('Role não permitida para este usuário');
        }

        $session->set('active_role', $role);
        return $this->redirectToRoute($this->navService->getHomeRoleRoute($role));
    }

    public function visitor(): Response
    {
        return $this->render('nav/visitor.html.twig', [
            'routes' => [
                'Home' => RouteName::APP_VISITOR,
                'About' => RouteName::APP_VISITOR,
            ],
        ]);
    }
}

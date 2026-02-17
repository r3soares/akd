<?php

namespace App\Controller\User;

use App\Routes\RouteName;
use App\Service\GlobalVars;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PreferenceController extends AbstractController
{
    function __construct(private readonly GlobalVars $globalVars)
    {}

    #[Route('/user/preference', name: RouteName::USER_PREFERENCE)]
    public function index(): Response
    {
        return $this->render('user/preference/index.html.twig', [
            'controller_name' => 'PreferenceController',
        ]);
    }

    #[Route(null, name: RouteName::APP_PREFERENCE_CHANGE_THEME)]
    public function changeTheme(Request $request) : Response
    {
        $currentTheme = $this->globalVars->theme;
        $this->globalVars->theme = ($currentTheme == 'light') ? 'dark' : 'light';
        return $this->redirect($request->headers->get('referer') ?? $this->generateUrl('user_home'));
    }
}

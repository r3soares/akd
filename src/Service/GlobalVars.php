<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class GlobalVars
{
    public function __construct(
        private RequestStack $requestStack)
    {}
    public string $theme {
        get {
            // Tenta pegar da sessão, se não existir, retorna 'light'
            $session = $this->requestStack->getSession();
            return $session->get('theme', 'light');
        }
        set {
            // Salva o novo valor na sessão
            $session = $this->requestStack->getSession();
            $session->set('theme', $value);
            $this->theme = $value;
        }
    }
}

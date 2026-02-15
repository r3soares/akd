<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WorkoutController extends AbstractController
{
    #[Route('/user/workout', name: 'user_workout')]
    public function index(): Response
    {
        return $this->render('user/workout/index.html.twig', [
            'controller_name' => 'WorkoutController',
            'workouts' => [
                'Treino A' => [
                    'Supino reto' => [
                        'serie' => '3x10',
                        'descricao' => 'barra/halteres'
                    ],
                    'Supino inclinado' => [
                        'serie' => '3x10',
                        'descricao' => 'barra/halteres'
                    ],
                    'Elevação lateral' => [
                        'serie' => '3x10',
                        'descricao' => 'halteres'
                    ],
                    'Encolhimento' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Tríceps francês' => [
                        'serie' => '3x10',
                        'descricao' => 'halteres'
                    ],
                    'Tríceps testa' => [
                        'serie' => '3x10',
                        'descricao' => 'halteres'
                    ],
                ],
                'Treino B' => [
                    'Barra fixa' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Puxada alta' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Pullover' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Rosca direta' => [
                        'serie' => '3x10',
                        'descricao' => 'barra/halteres'
                    ],
                    'Rosca 21' => [
                        'serie' => '3x10',
                        'descricao' => 'barra'
                    ],
                ],
                'Treino C' => [
                    'Agachamento livre' => [
                        'serie' => '3x10',
                        'descricao' => 'barra'
                    ],
                    'Leg press 45°' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Stiff' => [
                        'serie' => '3x10',
                        'descricao' => 'barra'
                    ],
                    'Cadeira flexora' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Cadeira extensora' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                    'Panturrilha sentado' => [
                        'serie' => '3x10',
                        'descricao' => ''
                    ],
                ],
                'Treino D' => [
                    'Prancha' => [
                        'serie' => '3x 30s',
                        'descricao' => 'livre'
                    ],
                    'Abdominal oblíquo' => [
                        'serie' => '3x15',
                        'descricao' => 'livre'
                    ],
                    'Hit na esteira ou bicicleta' => [
                        'serie' => '3x 30s',
                        'descricao' => 'descanso de 1 minuto entre os hits'
                    ],
                ]
            ]
        ]);
    }
}

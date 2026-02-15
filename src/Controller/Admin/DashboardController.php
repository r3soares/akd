<?php

namespace App\Controller\Admin;

use App\Entity\Exercise;
use App\Entity\ExerciseExecution;
use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin/', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator
            ->setController(ExerciseCrudController::class)
            ->setAction(Crud::PAGE_INDEX)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Akd');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Exercícios', 'fas fa-dumbbell', Exercise::class);
        yield MenuItem::linkToCrud('Execuções', 'fas fa-play', ExerciseExecution::class);
        yield MenuItem::linkToCrud('Treinos', 'fas fa-clipboard-list', Workout::class);
        yield MenuItem::linkToCrud('Grupos de Treinos', 'fas fa-list-check', WorkoutExercise::class);
        yield MenuItem::linkToRoute(
            'Modelos de Treino',
            'fa fa-layer-group',
            'admin_workout_models'
        );
    }
}

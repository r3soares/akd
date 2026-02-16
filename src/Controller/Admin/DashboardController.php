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

        // Injetando o AdminUrlGenerator
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Redireciona para o CRUD de Exercícios, por exemplo
        $url = $adminUrlGenerator
            ->setController(ExerciseCrudController::class) // Controller CRUD
            ->setAction('index') // ação padrão do CRUD
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
    }
}

<?php

namespace App\Controller\User;

use App\Form\ChangePasswordFormType;
use App\Form\UserFormType;
use App\Routes\RouteName;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/perfil')]
final class PerfilController extends AbstractController
{
    #[Route('', name: RouteName::USER_PERFIL)]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->add('email', null, ['disabled' => true]);
        $form->add('cpf', null, ['disabled' => true]);
        $form->add('birthday', null, ['disabled' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Perfil atualizado com sucesso!');
        }

        return $this->render('user/perfil/index.html.twig', [
            'controller_name' => 'PerfilController',
            'userForm' => $form
        ]);
    }

    #[Route('/password', name: RouteName::USER_PERFIL_PASSWORD)]
    public function updatePassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            /** @var string $plainPassword */
            $newPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
            // encode the plain password
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Senha atualizada com sucesso!');
            return $this->redirectToRoute(RouteName::USER_PERFIL);
        }

        return $this->render('user/perfil/change_password.html.twig', ['changePasswordForm' => $form]);
    }
}

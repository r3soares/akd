<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\CpfCnpj;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email', type: EmailType::class)
            ->add('gender', type: ChoiceType::class, options: [
                'choices'  => [
                    'Não informar' => null,
                    'Masculino' => 'masculino',
                    'Feminino' => 'feminino',
                    'Outro' => 'outro'
                ],
                'constraints' => [
                    new Required(),
                ],
            ])
            ->add('cpf', null, options: [
                'constraints' => [
                    new Required(),
                    new CpfCnpj()
                ],
            ])
            ->add('phone')
            ->add('birthday', type: BirthdayType::class, options: [
                'widget' => 'single_text',
                'constraints' => [
                    new Required()
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'As senhas devem coincidir.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Senha'],
                'second_options' => ['label' => 'Confirmar Senha'],
                'constraints' => [
                    new Length(min: 6, max: 4096, minMessage: 'Sua senha deve ter pelo menos {{ limit }} caracteres'),
                ],
            ])
            ->add('currentPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Senha Atual para salvar as alterações',
                'constraints' => [
                    new UserPassword(message: 'Senha incorreta'),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

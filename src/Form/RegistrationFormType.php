<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\CpfCnpj;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;

class RegistrationFormType extends AbstractType
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
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Length(min: 6, max: 4096, minMessage: 'Sua senha deve ter pelo menos {{ limit }} caracteres'),
                    new Required()
                ],
            ])
            ->add('plainPassword2', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Length(min: 6, max: 4096, minMessage: 'Sua senha deve ter pelo menos {{ limit }} caracteres'),
                    new Required()
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

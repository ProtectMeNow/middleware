<?php

namespace App\UI\Http\Rest\Form\User;

use App\Application\User\RegisterLogin\RegisterLoginCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterLoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'O e-mail não enviado')
                ],
            ])
            ->add('password', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'O senha não enviado')
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'data_class' => RegisterLoginCommand::class
        ]);
    }
}

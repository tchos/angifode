<?php

namespace App\Form;

use App\Entity\Organismes;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'label' => $this->translator->trans('Nom d\'utilisateur'),
                'attr' => [
                    'placeholder' => 'Ex: benedicto'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('Les deux mots de passe ne correspondent pas.'),
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => $this->translator->trans('Mot de passe')],
                'second_options' => ['label' => $this->translator->trans('Confimer le mot de passe')],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password']
                    ])
            ->add('fullName', TextType::class,[
                'label' => $this->translator->trans('Entrer le nom complet de l\'utilisateur'),
                'attr' => [
                    'placeholder' => "TUKO BENEDICTO PACIFICO"
                ]
            ])
            ->add('roles', ChoiceType::class,[
                'required' => true,
                'label' => $this->translator->trans('Rôle de l\'utilisateur'),
                'choices' => [
                    'Organisme' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'attr' => [
                    'default' => 'ROLE_USER'
                ]
            ])
            ->add('activation', ChoiceType::class,[
                'label' => $this->translator->trans('Activer le compte'),
                'choices' => [
                    'Oui' => true,
                    'Non    ' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'data' => true,
                'attr' => [
                    'default' => true
                ]
            ])
            ->add('organisme', EntityType::class,[
                'label' => $this->translator->trans('Organisme de détachement'),
                'class' => Organismes::class
            ])
        ;

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

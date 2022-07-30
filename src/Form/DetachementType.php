<?php

namespace App\Form;

use App\Entity\AgentDetache;
use App\Entity\Organismes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetachementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class,[
                'label' => 'Matricule de l\'agent',
                'attr' => [
                    'placeholder' => 'Ex: 999999Z ou A000000'
                ]
            ])
            ->add('noms', TextType::class,[
                'label' => 'Noms de l\'agent',
                'attr' => [
                    'placeholder' => 'Ex: TUKO BENEDICTO PACIFICO'
                ]
            ])
            ->add('telephone', TelType::class,[
                'label' => 'Téléphone de l\'agent',
                'attr' => [
                    'placeholder' => 'Ex: 677777777'
                ]
            ])
            ->add('dateNaissance', DateType::class, ['widget' => 'single_text'])
            ->add('dateIntegration', DateType::class, ['widget' => 'single_text'])
            ->add('refActeInt', TextType::class,[
                'label' => 'Référence de l\'acte de détachement',
                'attr' => [
                    'placeholder' => 'Ex: 000/SPM/DETACHEMENT'
                ]
            ])
            ->add('typeActeDet', ChoiceType::class,[
                'label' => 'Type acte de détachement',
                'choices' => [
                    'Arrêté' => 'ARRETE',
                    'Décret' => 'DECRET',
                    'Elu' => 'ELU',
                    'Décision' => 'DECISION'
                ]
            ])
            ->add('dateActeDet', DateType::class, ['widget' => 'single_text'])
            ->add('ministere', TextType::class,[
                'label' => 'Ministère',
                'attr' => [
                    'placeholder' => 'Ex: MINFOPRA'
                ]
            ])
            ->add('gradeDet', TextType::class,[
                'label' => 'Grade',
                'attr' => [
                    'placeholder' => 'Ex: INGENIEUR INFORMATICIEN'
                ]
            ])
            ->add('echelonDet', TextType::class,[
                'label' => 'Echelon',
                'attr' => [
                    'placeholder' => 'Ex: 05'
                ]
            ])
            ->add('classeDet', TextType::class,[
                'label' => 'Classe',
                'attr' => [
                    'placeholder' => 'Ex: 1'
                ]
            ])
            ->add('refActeDet')
                ->add('dateDet')
            ->add('dateSuspension')
            ->add('datePriseService')
            ->add('organisme', EntityType::class,[
                'class' => Organismes::class,
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgentDetache::class,
        ]);
    }
}

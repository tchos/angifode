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
                    'placeholder' => 'Ex: TUKO BENEDICTO PACIFICO',
                ]
            ])
            ->add('telephone', TelType::class,[
                'label' => 'Téléphone de l\'agent',
                'attr' => [
                    'placeholder' => 'Ex: 677777777'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                ])
            ->add('dateIntegration', DateType::class, [
                'label' => 'Date d\'intégration',
                'widget' => 'single_text'])
            ->add('refActeInt', TextType::class,[
                'label' => 'Référence de l\'acte d\'intégration',
                'attr' => [
                    'placeholder' => 'Ex: 000/SPM/INT',
                    'style' => 'text-transform:uppercase'
                ]
            ])
            ->add('typeActeDet', ChoiceType::class,[
                'label' => 'Type acte',
                'choices' => [
                    'Arrêté' => 'ARRETE',
                    'Décret' => 'DECRET',
                    'Elu' => 'ELU',
                    'Décision' => 'DECISION'
                ]
            ])
            ->add('dateActeDet', DateType::class, [
                'label' => 'Date de signature',
                'widget' => 'single_text'])
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
            ->add('refActeDet', TextType::class,[
                'label' => 'Références de l\'acte',
                'attr' => [
                    'placeholder' => 'Ex: 1234/SPM/DET',
                    'style' => 'text-transform:uppercase'
                ]
            ])
            ->add('dateDet', DateType::class, [
                'label' => 'Date de détachement',
                'widget' => 'single_text'])
            ->add('dateSuspension',DateType::class, [
                'label' => 'Date de suspension solde',
                'widget' => 'single_text'])
            ->add('datePriseService', DateType::class, [
                'label' => 'Prise de service organisme',
                'widget' => 'single_text'])
            ->add('organisme', EntityType::class,[
                'label' => 'Organisme de détachement',
                'class' => Organismes::class
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

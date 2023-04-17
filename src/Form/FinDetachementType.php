<?php

namespace App\Form;

use App\Entity\FinDetachement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinDetachementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateFinDet', DateType::class, [
                'label' => 'Date de fin détachement',
                'widget' => 'single_text'
            ])
            ->add('motifFinDet', ChoiceType::class, [
                'label' => 'Motif du fin de détachement',
                'choices' => [
                    'Par la structure' => 'La structure a mis fin au détachement',
                    'Retour au ministère d\'origine' => 'Retour au ministère d\'origine',
                    'Nommination à autre poste' => 'L\agent détaché a été nommé à un autre poste',
                    'Remplacé au poste' => 'L\'agent détaché a été remplacé à son poste suite à une nommination',
                    'Retraite' => 'Appelé à faire valoir ses droit à la retraite',
                    'Décès' => 'Décès de l\'agent détaché',
                ]
            ])
            ->add('refActeFinDet', TextType::class,[
                'label' => 'Référence de l\'acte mettant fin au détachement',
                'attr' => [
                    'placeholder' => 'Ex: 1234/PRC/DET',
                ]
            ])
            ->add('dateSigneActFinDet', DateType::class, [
                'label' => 'Date signature de l\'acte mettant fin au détachement',
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FinDetachement::class,
        ]);
    }
}

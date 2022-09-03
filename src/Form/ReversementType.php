<?php

namespace App\Form;

use App\Entity\Organismes;
use App\Entity\Reversement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReversementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeRev',ChoiceType::class,[
                'label' => "Quel moyen de réversement avez-vous utilisé ?",
                'choices' => [
                    'CHEQUE' => 'CHEQUE',
                    'VIREMENT' => 'VIREMENT',
                    'VERSEMENT TRESOR' => 'VERSEMENT TRESOR'
                ]
            ])
            ->add('refTitre', TextType::class,[
                'label' => 'Entrez les références du moyen de reversement',
                'attr' => [
                    'placeholder' => 'Ex: 123456789'
                ]
            ])
            ->add('dateTitre', DateType::class,[
                'label' => 'Date du versement',
                'widget' => 'single_text'
            ])
            ->add('montantRev', MoneyType::class,[
                'label' => 'Montant du reversement',
                'currency' => 'CFA',
                'attr' => [
                    'placeholder' => 'Ex: 10000000'
                ]
            ])
            ->add('dateDebRev', DateType::class,[
                'label' => 'Date de début de réversement',
                'widget' => 'single_text'
            ])
            ->add('dateFinRev', DateType::class,[
                'label' => 'Date de fin de réversement',
                'widget' => 'single_text'
            ])
            ->add('preuveRev', FileType::class,[
                'label' => 'Téléverser une copie scannée de la preuve de réversement',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10m',
                        'maxSizeMessage' => 'La taille maximale dépasse 10 Mo',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de téléverser le fichier au format pdf',
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Vous devez impérativement insérer une preuve de réversement'
                    ])
                ],
            ])
            ->add('organisme', EntityType::class,[
                'label' => 'Organisme ayant effectué le reversement',
                'class' => Organismes::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reversement::class,
        ]);
    }
}

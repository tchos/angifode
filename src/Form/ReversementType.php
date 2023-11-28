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
use Symfony\Contracts\Translation\TranslatorInterface;

class ReversementType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $organismes = $options['organisme'];
        $builder
            ->add('typeRev',ChoiceType::class,[
                'label' => $this->translator->trans("Moyen de reversement"),
                'choices' => [
                    'CHEQUE' => 'CHEQUE',
                    'VIREMENT' => 'VIREMENT',
                    'VERSEMENT TRESOR' => 'VERSEMENT TRESOR'
                ]
            ])
            ->add('refTitre', TextType::class,[
                'label' => $this->translator->trans('Référence du moyen de reversement'),
                'attr' => [
                    'placeholder' => 'Ex: 123456789'
                ]
            ])
            ->add('dateTitre', DateType::class,[
                'label' => $this->translator->trans('Date de reversement'),
                'widget' => 'single_text'
            ])
            ->add('montantRev', MoneyType::class,[
                'label' => $this->translator->trans('Montant du reversement'),
                'currency' => 'CFA',
                'attr' => [
                    'placeholder' => 'Ex: 10000000'
                ]
            ])
            ->add('dateDebRev', DateType::class,[
                'label' => $this->translator->trans('Date de début de période de reversement'),
                'widget' => 'single_text'
            ])
            ->add('dateFinRev', DateType::class,[
                'label' => $this->translator->trans('Date de fin de période de reversement'),
                'widget' => 'single_text'
            ])
            ->add('preuveRev', FileType::class,[
                'label' => $this->translator->trans('Téléverser une copie scannée de la preuve de reversement au format PDF'),
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10m',
                        'maxSizeMessage' => $this->translator->trans('La taille maximale dépasse 10 Mo'),
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => $this->translator->trans('Merci de téléverser le fichier au format pdf'),
                    ]),
                    new Assert\NotBlank([
                        'message' => $this->translator->trans('Vous devez impérativement insérer une preuve de réversement')
                    ])
                ],
            ])
            ->add('organisme', EntityType::class,[
                'label' => $this->translator->trans('Organisme ayant effectué le reversement'),
                'class' => Organismes::class,
                'choices' => $organismes
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reversement::class,
        ]);

        $resolver->setDefined('organisme');
        $resolver->setRequired(['organisme']);
    }
}

<?php

namespace App\Form;

use App\Classe\Esd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EsdType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class,[
                'label' => $this->translator->trans('Date début de période'),
                'widget' => 'single_text'
            ])
            ->add('dateFin', DateType::class,[
                'label' => $this->translator->trans('Date fin de période'),
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Esd::class,
            'csrf_protection' => false
        ]);
    }
}

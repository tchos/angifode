<?php

namespace App\Form;

use App\Entity\FinDetachement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class FinDetachementType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateFinDet', DateType::class, [
                'label' => $this->translator->trans('Date de fin détachement'),
                'widget' => 'single_text'
            ])
            ->add('motifFinDet', ChoiceType::class, [
                'label' => $this->translator->trans('Motif du fin de détachement'),
                'choices' => [
                    'Par la structure' => $this->translator->trans('La structure a mis fin au détachement'),
                    'Retour au ministère d\'origine' => $this->translator->trans('Retour au ministère d\'origine'),
                    'Nommination à autre poste' => $this->translator->trans('L\agent détaché a été nommé à un autre poste'),
                    'Remplacé au poste' => $this->translator->trans('L\'agent détaché a été remplacé à son poste suite à une nommination'),
                    'Retraite' => $this->translator->trans('Appelé à faire valoir ses droit à la retraite'),
                    'Décès' => $this->translator->trans('Décès de l\'agent détaché'),
                ]
            ])
            ->add('refActeFinDet', TextType::class,[
                'label' => 'Référence de l\'acte mettant fin au détachement',
                'attr' => [
                    'placeholder' => 'Ex: 1234/PRC/DET',
                ]
            ])
            ->add('dateSigneActFinDet', DateType::class, [
                'label' => 'Date de signature de l\'acte mettant fin au détachement',
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

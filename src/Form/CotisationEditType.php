<?php

namespace App\Form;

use App\Entity\Cotisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class CotisationEditType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cotSalariale', MoneyType::class, [
                'label' => $this->translator->trans('Part salariale'),
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 100000']
            ])
            ->add('cotPatronale', MoneyType::class, [
                'label' => $this->translator->trans('Contribution patronale'),
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 120000']
            ])
            ->add('cotTotale', MoneyType::class, [
                'label' => $this->translator->trans('Cotisation totale'),
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 220000']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cotisation::class,
        ]);
    }
}

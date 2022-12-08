<?php

namespace App\Form;

use App\Entity\AgentDetache;
use App\Entity\Cotisation;
use App\Entity\Reversement;
use App\Repository\AgentDetacheRepository;
use App\Services\Services;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CotisationType extends AbstractType
{
    private $statistiques;
    public function __construct(Services $statistiques)
    {
        $this->statistiques = $statistiques;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $anc = $options['anc'];
        //dd($this->statistiques->getListeACotiser($reversement));
        $builder
            ->add('cotSalariale', MoneyType::class, [
                'label' => 'Part salariale',
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 100000']
            ])
            ->add('cotPatronale', MoneyType::class, [
                'label' => 'Contribution patronale',
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 120000']
            ])
            ->add('cotTotale', MoneyType::class, [
                'label' => 'Cotisation totale',
                'currency' => 'CFA',
                'attr' => ['placeholder' => 'Ex: 220000']
            ])
            ->add('agentdetache', ChoiceType::class, [
                'mapped' => false,
                'label' => 'Agents détachés',
                'choices' => $anc,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cotisation::class,
        ]);

        $resolver->setDefined('anc');
        $resolver->setRequired(['anc']);
    }
}

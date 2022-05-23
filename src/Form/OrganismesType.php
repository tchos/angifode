<?php

namespace App\Form;

use App\Entity\Organismes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganismesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleOrg', TextType::class, [
                'label' => 'Libelle de l\'organisme',
                'attr' => [
                    'placeholder' => 'Ex: Cameroon Telecommunications'
                ]
            ])
            ->add('sigle', TextType::class, [
                'label' => 'Sigle de l\'organisme',
                'attr' => [
                    'placeholder' => 'Ex: Cametel'
                ]
            ])
            ->add('siege')
            ->add('bp')
            ->add('region')
            ->add('fax')
            ->add('email', EmailType::class, [
                'label' => 'Email de l\'organisme',
                'attr' => [
                    'placeholder' => 'Ex: camtel@camtel.cm'
                ]
            ]
            )
            ->add('telephone1')
            ->add('telephone2')
            ->add('ville')
            ->add('quartier')
            ->add('siteWeb')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organismes::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Organismes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrganismesType extends AbstractType
{
    public $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelleOrg', TextType::class, [
                'label' => $this->translator->trans('Nom de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: CAMEROON TELECOMMUNICATION'
                ]
            ])
            ->add('sigle', TextType::class, [
                'label' => $this->translator->trans('Sigle de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: CAMTEL'
                ]
            ])
            ->add('siege', TextType::class,[
                'label' => $this->translator->trans('Siège de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: YAOUNDE-BASTOS'
                ]
            ])
            ->add('bp', TextType::class,[
                'label' => $this->translator->trans('Boîte postale de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: BP 1600 YAOUNDE'
                ]
            ])
            ->add('fax', TelType::class,[
                'label' => $this->translator->trans('Fax de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: 222222222'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('Email de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: camtel@camtel.cm'
                ]
            ]
            )
            ->add('telephone1', TelType::class,[
                'label' => $this->translator->trans('Téléhone 1'),
                'attr' => [
                    'placeholder' => 'Ex: 677777777'
                ]
            ])
            ->add('telephone2', TelType::class,[
                'label' => $this->translator->trans('Téléhone 2'),
                'attr' => [
                    'placeholder' => 'Ex: 699999999',
                    'required' => false
                ]
            ])
            ->add('ville', TextType::class,[
                'label' => $this->translator->trans('Ville où se trouve l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: YAOUNDE II'
                ]
            ])
            ->add('quartier', TextType::class,[
                'label' => $this->translator->trans('Localité de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: QUARTIER FOUDA'
                ]
            ])
            ->add('siteWeb', UrlType::class,[
                'label' => $this->translator->trans('Site web de l\'organisme'),
                'attr' => [
                    'placeholder' => 'Ex: www.camtel.cm'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organismes::class,
        ]);
    }
}

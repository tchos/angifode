<?php

namespace App\Form;

use App\Entity\AgentDetache;
use App\Entity\Organismes;
use App\Repository\AgentDetacheRepository;
use App\Repository\OrganismesRepository;
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
        $organismes = $options['organisme'];
        $builder
            ->add('matricule', TextType::class,[
                'label' => 'Matricule de l\'agent',
                'attr' => [
                    'placeholder' => 'Ex: 999999Z/A000000'
                ]
            ])
            ->add('noms', TextType::class,[
                'label' => 'Nom de l\'agent',
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
            ->add('dateDernierAvct', DateType::class, [
                'label' => 'Date dernier avancement',
                'widget' => 'single_text',
            ])
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
            ->add('ministere', ChoiceType::class, [
                'label' => 'Ministère d\'origine',
                'choices' => [
                    'PRC' => '01',
                    'MINRA' => '02',
                    'SPM' => '03',
                    'DGSN' => '04',
                    'MINREX' => '06',
                    'MINREST' => '06',
                    'MINAT' => '07',
                    'MINJUSTICE' => '08',
                    'MINDDEVEL' => '09',
                    'MINMAP' => '10',
                    'MINDEF' => '13',
                    'MINAC' => '14',
                    'MINEDUB' => '15',
                    'MINSEP' => '16',
                    'MINCOM' => '17',
                    'MINESUP' => '18',
                    'MINRESI' => '19',
                    'MINFI' => '20',
                    'MINCOMMERCE' => '21',
                    'MINEPAT' => '22',
                    'MINTOUL' => '23',
                    'MINESEC' => '25',
                    'MINJEC' => '26',
                    'MINEPDED' => '28',
                    'MINMIDT' => '29',
                    'MINADER' => '30',
                    'MINEPIA' => '31',
                    'MINEE' => '32',
                    'MINFOF' => '33',
                    'MINEFOP' => '35',
                    'MINTP' => '36',
                    'MINDCAF' => '37',
                    'MINHDU' => '38',
                    'MINPMEESA' => '39',
                    'MINSANTE' => '40',
                    'MINTSS' => '41',
                    'MINAS' => '42',
                    'MINPROFF' => '43',
                    'MINPOSTEL' => '45',
                    'MINT' => '46',
                    'MINFOPRA' => '50',
                    'PENSIONNES' => '55',
                    'CONSUPE' => '60',
                    'COURSUP' => '81',
                    'TAMPON' => '99',
                ],
            ])
            ->add('gradeDet', TextType::class,[
                'label' => 'Grade',
                'attr' => [
                    'placeholder' => 'Ex: INGENIEUR INFORMATICIEN'
                ]
            ])
            ->add('echelonDet', ChoiceType::class,[
                'label' => 'Echelon',
                'choices' => [
                    '00' => '00',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12'
                ]
            ])
            ->add('classeDet', ChoiceType::class,[
                'label' => 'Classe',
                'choices' => [
                    '0' => '0',
                    '2' => '2',
                    '1' => '1',
                    'E' => 'E',
                    'H' => 'H'
                ]
            ])
            ->add('refActeDet', TextType::class,[
                'label' => 'Référence de l\'acte',
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
                'class' => Organismes::class,
                'choices' => $organismes
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgentDetache::class,
        ]);

        $resolver->setDefined('organisme');
        $resolver->setRequired(['organisme']);
    }
}

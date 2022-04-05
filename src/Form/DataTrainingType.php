<?php

namespace App\Form;

use App\Entity\DataTraining;
use App\Entity\Pokja;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class DataTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jenis_pengadaan', ChoiceType::class, [
                'choices' => [
                    'BARANG' => 'BARANG',
                    'KONSULTASI' => 'KONSULTASI',
                    'KONSTRUKSI' => 'KONSTRUKSI',
                    'JASA LAINNYA' => 'JASA LAINNYA'
                ],
            ])
            ->add('sumber_dana', ChoiceType::class, [
                'choices' => [
                    'APBD' => 'APBD',
                    'APBN' => 'APBN',
                    'BLUD' => 'BLUD',
                    'LAINNYA' => 'LAINNYA'
                ],
            ])
            ->add('jenis_paket', ChoiceType::class, [
                'choices' => [
                    'umum' => 'umum',
                    'dikecualikan' => 'dikecualikan'
                ],
            ])
            ->add('pagu', )
            ->add('pokja', EntityType::class, [
                'class' => Pokja::class,
                'choice_label' => 'nama_pokja',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DataTraining::class,
        ]);
    }
}

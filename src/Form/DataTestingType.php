<?php

namespace App\Form;

use App\Entity\DataTesting;
use App\Entity\DataTraining;
use App\Entity\JenisPengadaan;
use App\Entity\SumberDana;
use App\Entity\JenisKontrak;
use App\Entity\Pagu;
use App\Entity\Pokja;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataTestingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jenis_pengadaan', ChoiceType::class, [
                'placeholder' => '',
                'choices' => [
                    'BARANG' => 'BARANG',
                    'KONSTRUKSI' => 'KONSTRUKSI',
                    'KONSULTASI' => 'KONSULTASI',
                    'JASA LAINNYA' => 'JASA LAINNYA'
                ]
            ])
            ->add('sumber_dana', ChoiceType::class,  [
                'placeholder' => '',
                'choices' => [
                    'APBD' => 'APBD',
                    'APBN' => 'APBN',
                    'BLUD' => 'BLUD',
                    'LAINNYA' => 'LAINNYA'
                ]
            ])
            ->add('jenis_kontrak', ChoiceType::class, [
                'placeholder' => '',
                'choices' => [
                    'LUMSUM' => 'LUMSUM',
                    'HARGA SATUAN' => 'HARGA SATUAN',
                    'GABUNGAN LUMSUM DAN HARGA SATUAN' => 'GABUNGAN LUMSUM DAN HARGA SATUAN',
                    'WAKTU PENUGASAN' => 'WAKTU PENUGASAN'
                ]
            ])
            ->add('pagu', ChoiceType::class, [
                'placeholder' => '',
                'choices' => [
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary', 'id' => 'submit'],
            ])
        ;
        
    }

    public function getBlockPrefix()
    {
        return '';
    }
    
    public function getHai()
    {
        return 'hai';
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DataTesting::class,
        ]);
    }
}
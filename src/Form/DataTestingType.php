<?php

namespace App\Form;

use App\Entity\DataTraining;
use App\Entity\JenisPengadaan;
use App\Entity\SumberDana;
use App\Entity\JenisKontrak;
use App\Entity\Pagu;
use App\Entity\Pokja;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataTestingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jenis_pengadaan', EntityType::class, [
                'class' => JenisPengadaan::class,
                'choice_label' => 'nama_jenis_pengadaan',
                'required' => false
            ])
            ->add('sumber_dana', EntityType::class, [
                'class' => SumberDana::class,
                'choice_label' => 'nama_sumber_dana',
                'required' => false
            ])
            ->add('jenis_kontrak', EntityType::class, [
                'class' => JenisKontrak::class,
                'choice_label' => 'nama_jenis_kontrak',
                'required' => false
            ])
            ->add('pagu', EntityType::class, [
                'class' => Pagu::class,
                'choice_label' => 'range_pagu',
                'required' => false
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
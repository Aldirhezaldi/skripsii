<?php

namespace App\Form;

use App\Entity\DataTraining;
use App\Entity\JenisKontrak;
use App\Entity\JenisPaket;
use App\Entity\JenisPengadaan;
use App\Entity\Pokja;
use App\Entity\SumberDana;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pokja', EntityType::class, [
                'class' => Pokja::class,
                'choice_label' => 'nama_pokja',
                'required' => false
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DataTraining::class,
        ]);
    }
}

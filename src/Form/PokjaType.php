<?php

namespace App\Form;

use App\Entity\Pokja;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokjaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nama_pokja', TextType::class, [
                'label' => 'Nama Pokja'
            ])
            ->add('surat_keputusan', TextType::class, [
                'label' => 'Surat Keputusan'
            ])
            ->add('tanggal_sk', DateType::class, [
                'data' => new \DateTime(),
                'label' => 'Tanggal Keputusan'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokja::class,
        ]);
    }
}

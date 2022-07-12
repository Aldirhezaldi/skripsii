<?php

/**
 * Generated by kematjaya/crud-maker-bundle 
 * Report any bug on Girhub: https://github.com/kematjaya0/crud-maker-bundle 
 * form more information about Type, please visit https://github.com/lexik/LexikFormFilterBundle
 */
namespace App\Filter;

use Symfony\Component\Form\FormBuilderInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Kematjaya\BaseControllerBundle\Filter\AbstractFilterType;

/**
 * Description of App\Filter\DtTrainingFilterType *
 */
class DtTrainingFilterType extends AbstractFilterType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('no', Filters\TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
                ->add('pokja', Filters\TextFilterType::class, [
           'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
                    ->add('jenis_pengadaan', Filters\TextFilterType::class, [
           'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
                    ->add('sumber_dana', Filters\TextFilterType::class, [
           'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
        ->add('jenis_kontrak', Filters\TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
        ->add('pagu', Filters\TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS
        ])
            ;
    }
}

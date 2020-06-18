<?php

namespace App\Form;

use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstTrimesterFile', FileType::class, [
                'label' => '1er trimestre',
                'required' => true,
                ])
            ->add('secondTrimesterFile', FileType::class, [
                'label' => '2ème trimestre',
                'required' => true,
                ])
            ->add('thirdTrimesterFile', FileType::class, [
                'label' => '3ème trimestre',
                'required' => true,
                ])
            ->add('fourthTrimesterFile', FileType::class, [
                'label' => '4ème trimestre',
                'required' => true,
                ])
            ->add('activityFile', FileType::class, [
                'label' => 'Fichier événements',
                'required' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
        ]);
    }
}

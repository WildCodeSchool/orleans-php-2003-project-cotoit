<?php

namespace App\Form;

use App\Entity\Portfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PortfolioType extends AbstractType
{
    const PLACEHOLDER = 'Aucun fichier sélectionné';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstTrimesterFile', FileType::class, [
                'label' => '1er trimestre',
                'attr' => [
                    'placeholder' => self::PLACEHOLDER,
                ],
                'required' => true,
                ])
            ->add('secondTrimesterFile', FileType::class, [
                'label' => '2e trimestre',
                'attr' => [
                    'placeholder' => self::PLACEHOLDER,
                ],
                'required' => true,
                ])
            ->add('thirdTrimesterFile', FileType::class, [
                'label' => '3e trimestre',
                'attr' => [
                    'placeholder' => self::PLACEHOLDER,
                ],
                'required' => true,
                ])
            ->add('fourthTrimesterFile', FileType::class, [
                'label' => '4e trimestre',
                'attr' => [
                    'placeholder' => self::PLACEHOLDER,
                ],
                'required' => true,
                ])
            ->add('activityFile', FileType::class, [
                'label' => 'Fichier événements',
                'attr' => [
                    'placeholder' => self::PLACEHOLDER,
                ],
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

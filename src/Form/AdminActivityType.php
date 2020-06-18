<?php

namespace App\Form;

use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Activité',
                'empty_data' => '',
            ])
            ->add('hours', IntegerType::class, [
                'label' => 'Heures',
                'empty_data' => '0',
                'error_bubbling' => true,
            ])
            ->add('minutes', IntegerType::class, [
                'label' => 'Minutes',
                'empty_data' => '0',
                'error_bubbling' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}

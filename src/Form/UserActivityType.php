<?php

namespace App\Form;

use App\Entity\UserActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('activities', CollectionType::class, [
            'entry_type' => ActivityType::class,
            'entry_options' => ['label' => false],
        ]);
        $builder->add('Enregistrer', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary row ml-2 mb-3'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserActivity::class,
            'label' => false,
        ]);
    }
}

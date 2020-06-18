<?php


namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AdminActivityType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('name');
    }
}

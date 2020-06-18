<?php


namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class ActivityType extends AdminActivityType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $nameField = $builder->get('name');
        $nameFieldType = get_class($nameField->getType()->getInnerType());
        $nameFieldOptions = $nameField->getOptions();
        $nameFieldOptions['attr'] = ['style' => 'display:none'];
        $nameFieldOptions['label'] = false;

        $builder->add($nameField->getName(), $nameFieldType, $nameFieldOptions);
    }
}

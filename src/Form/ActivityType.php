<?php


namespace App\Form;

use App\Entity\Activity;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Range;

class ActivityType extends AdminActivityType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('name');

        $hoursField = $builder->get('hours');
        $hoursFieldType = get_class($hoursField->getType()->getInnerType());
        $hoursFieldOptions = $hoursField->getOptions();
        $hoursFieldOptions = [
            'constraints' => [
                new PositiveOrZero([
                    'message' => 'Le nombre d\'heures allouées à l\'activité doit être égal à 0 ou positif'
                ]),
            ]
        ];

        $minutesField = $builder->get('minutes');
        $minutesFieldType = get_class($minutesField->getType()->getInnerType());
        $minutesFieldOptions = $minutesField->getOptions();
        $minutesFieldOptions = [
            'constraints' => [
                new Range([
                    'min' => 0,
                    'max' => 59,
                    'minMessage' => 'Le nombre de minutes allouées à l\'activité doit être au minimum de {{ limit }}',
                    'maxMessage' => 'Le nombre de minutes allouées à l\'activité doit être au maximum de {{ limit }}',
                ]),
            ],
        ];

        $builder->add($hoursField->getName(), $hoursFieldType, $hoursFieldOptions);
        $builder->add($minutesField->getName(), $minutesFieldType, $minutesFieldOptions);
    }
}

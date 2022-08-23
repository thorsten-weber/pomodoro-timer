<?php

namespace App\Form;

use App\Entity\Pomodoros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PomodorosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duration')
            ->add('short_break')
            ->add('long_break')
            ->add('cycles')
//            ->add('creation_date')
            ->add('cycles_to_long_break')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pomodoros::class,
        ]);
    }
}

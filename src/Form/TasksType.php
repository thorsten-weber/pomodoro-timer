<?php

namespace App\Form;

use App\Entity\Tasks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
//            ->add('save', SubmitType::class, [
//                'label' => 'Create Task',
//                'attr' => [
//                    'value' => 'create-task',
//                    'data-turbo-method' => 'new'
//                ]
//            ])
//            ->add('saveAndAdd', SubmitType::class, [
//                'label' => 'Save and Add',
//                'attr' => [
//                    'value' => 'save-and-add',
//                    'data-turbo-method' => 'edit'
//                ]
//            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tasks::class,
        ]);
    }
}

<?php

namespace App\Form\Type;
use App\Entity\Task;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'shadow-sm rounded-md w-full px-3 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900',
                    'placeholder' => 'Title',
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-900 mb-2',
                ],
            ])
            ->add('body', TextareaType::class, [
                'attr' => [
                    'class' => 'shadow-sm rounded-md w-full px-3 py-2 mb-4 border border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900',
                    'placeholder' => 'body',
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-900 mb-2',
                ],
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'w-full flex justify-center mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-50 bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
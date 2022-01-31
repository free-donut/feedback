<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppealFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Статус',
                'choices' => $options['statuses'],

            ])
            ->add('phone', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Телефон',
                'choices' => $options['phones'],

            ])
            ->add('customer', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'Клиент',
                'choices' => $options['customers'],

            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Фильтр',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->add('reset', ResetType::class, [
                'label' => 'Сбросить',
                'attr' => ['class' => 'btn btn-secondary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'csrf_protection' => false,
            'statuses' => null,
            'phones' => null,
            'customers' => null,
        ]);
    }
}

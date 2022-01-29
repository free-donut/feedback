<?php

namespace App\Form;

use App\Entity\Appeal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AppealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', TextType::class, [
                'label' => 'Клиент',
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
                'empty_data' => '+7(999)999-99-99',
            ]);
        if ($options['showStatus']) {
            $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Статус',
                'choices' => array_flip(Appeal::STATUS_NAMES),
            ]);
        } else {
            $builder
            ->add('status', HiddenType::class, [
               'data' => 0,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appeal::class,
            'showStatus' => false,
        ]);
    }
}

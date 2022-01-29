<?php

namespace App\Form;

use App\Entity\Appeal;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Config\Status;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AppealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer')
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
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'На модерации' => 0,
                    'Обработана' => 1,
                    'Отклонена' => 2,
                ),
            ));
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

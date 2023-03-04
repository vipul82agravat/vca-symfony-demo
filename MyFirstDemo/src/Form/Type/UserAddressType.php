<?php 
// src/Form/Type/TaskType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Translation\TranslatableMessage;

class UserAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('house_number', TextType::class,['label' => 'Enter Name'])
            ->add('user', ChoiceType::class, [
                'choices'  => [
                    'Select Users' => null,
                    '1' => "user1",
                    '2' => "user2",
                ],
            ])
            
            ->add('save', SubmitType::class,['label' => 'Save Users Address']);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
    }
}
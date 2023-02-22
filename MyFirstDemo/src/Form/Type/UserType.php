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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,['label' => 'Enter Name'])
            ->add('email', TextType::class,['label' => 'Enter Email',])
            ->add('password', PasswordType::class,[
                //'hash_property_path' => 'password',
                'mapped' => false,
                'label' => 'Enter Password'
            ])
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Select Gender' => null,
                    'Male' => "Male",
                    'Female' => "Female",
                ],
            ])->add('desciption', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('token', HiddenType::class,['data' => 'abcdef'])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Select status' => null,
                    'Active' => 0,
                    'InActive' => 1,
                ],'help'=>'Default status is Active now every time'
            ])
            ->add('save', SubmitType::class,['label' => 'Register Users'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // ...,
            'email_is' => false,
        ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('email_is', 'bool');
    }
}
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Form\EventListener\UserFromEventListener;

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
            ->addEventSubscriber(new UserFromEventListener())
            //add the form event to get the function call base on event call
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                [$this, 'onPreSetData']
            )->addEventListener(
                FormEvents::POST_SET_DATA,
                [$this, 'onPostSetData']
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'onPreSubmit']
            )
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                [$this, 'onPostSubmit']
            )
            
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
    // form event for pre set data
    public function onPreSetData(FormEvent $event): void
    {
        echo "<br>";
        echo "onPostSetData EventListener event is call";
        echo "<br>";
        // ...
    }
    // form event for post set data
    
    public function onPostSetData(FormEvent $event): void
    {
        echo "onPostSetData EventListener event is call";
        // ...
    }
    // form event for pre submit data
    
    public function onPreSubmit(FormEvent $event): void
    {
        echo "<br>";
        echo "onPreSubmit EventListener event is call" ;
        echo "<br>";
        //  dd('onPreSubmit');
        // ...
    }
    // form event for prposte submit data
    
    public function onPostSubmit(FormEvent $event): void
    {
        echo "onPostSubmit EventListener event is call";
       //dd('onPostSubmit');
        // ...
    }
}
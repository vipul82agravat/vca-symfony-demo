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
use App\Entity\User;
use App\Entity\Branch;
use App\Form\EventListener\UserFromEventListener;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\BranchRepository;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class BranchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $userChoices = $options['choices'];
        $builder
            ->add('name', TextType::class,['label' => 'Enter Name'])
            //->add('user',ChoiceType::class,['choices' => $userChoices,])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function ($user) {
                    return $user->getName();
                }
            ])
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
            'choices' => array('1'=>'1','2'=>'2'),
            //'class' => App\Entity\User   
        ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        //$resolver->setAllowedTypes('email_is', 'bool');
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

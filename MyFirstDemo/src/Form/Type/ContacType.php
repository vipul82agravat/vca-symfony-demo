<?php 
// src/Form/Type/TaskType.php
namespace App\Form\Type;


use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
//use Symfony\Component\Validator\Constraints;

class ContacType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,['label' => 'Enter First Name','attr' => ['placeholder' => 'Enter First Name'],])
            ->add('lastname', TextType::class,['label' => 'Enter Last Name','attr' => ['placeholder' => 'Enter Last Name']])
            ->add('email', EmailType::class,[
                'label' => 'Enter Email','attr' => ['placeholder' => 'Enter Email    Name']
            ])
            ->add('phonenumber', TelType::class,['label' => 'Enter Phone NUmber','attr' => ['placeholder' => 'Enter Phone Number']])
            ->add('note', TextareaType::class, [
                'required'=>true,
                //'constraints' => [new Length(['min' => 3])],
                'attr' => ['placeholder' => 'Enter some notes'],
            ])
            ->add('save', SubmitType::class,['label' => 'Save'])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class'=>Contact::class]);
    }

}
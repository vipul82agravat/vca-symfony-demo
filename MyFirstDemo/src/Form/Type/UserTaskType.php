<?php 
// src/Form/Type/TaskType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Form\EventListener\UserFromEventListener;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormError;

class UserTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('taskname', TextType::class,['label' => 'Enter Name',])
            ->add('startdate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('enddate', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'js-datepicker'],
            ])
            // ->add('enddate', DateType::class)
                       ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Select status' => null,
                    'Active' => 0,
                    'InActive' => 1,
                ],'help'=>'Default status is Active now every time'
            ])
            //->addEventSubscriber(new UserFromEventListener())
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
            
            ->add('save', SubmitType::class,['label' => 'Add Users Task'])
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
            $form = $event->getForm();
            $formdata=$event->getData();
            $taskname=$formdata['taskname'];  
            $startdate=$formdata['startdate'];  
            $enddate=$formdata['enddate'];  

            if(empty($taskname) and $taskname==null){   
                
                $form->get('taskname')->addError(new FormError('form_error_type_already_exist'));
            }
            if ($enddate < $startdate or $startdate == $enddate ) {
               
                $form->get('enddate')->addError(new FormError('end  date is not less then start date '));
            } 
            
        // ...
    }
    // form event for prposte submit data
    
    public function onPostSubmit(FormEvent $event): void
    {
        //  $routeParams = $request->attributes->get('user_task_add_form');
         
            $form=$event->getForm();

            if($form->isValid()){
                 return;
            }
            else{
               $form->getErrors(true, false);
             
            }
        echo "onPostSubmit EventListener event is call";
       //dd('onPostSubmit');
        // ...
    }
}
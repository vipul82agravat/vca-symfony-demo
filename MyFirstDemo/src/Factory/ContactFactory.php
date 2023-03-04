<?php 
 
 namespace App\Factory;

 use App\Entity\Contact;
 use App\Form\Type\ContacType;
 use Symfony\Component\Form\FormInterface;

 class ContactFactory {

    public static function CreateFromForm(FormInterface $form): Contact
    {
        $contact= new Contact();
        $contact->setFirstname($form->get('firstname')->getData());
        $contact->setLastname($form->get('lastname')->getData());
        $contact->setEmail($form->get('email')->getData());
        $contact->setPhonenumber($form->get('phonenumber')->getData());
        $contact->setNote($form->get('note')->getData());

        return $contact;

    }
 }
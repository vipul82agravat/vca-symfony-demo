<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContacType;
use App\Factory\ContactFactory;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{


    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
    #[Route('/contact_create', name: 'app_contact_create')]
    public function createContact(Request $request,ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form=$this->createForm(ContacType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $contact=ContactFactory::CreateFromForm($form);
            $contactRepository->save($contact,true);
            $this->addFlash('success',"Contact details save successfully");
             
        }
        return $this->render('contact/form.html.twig', [
            'form' => $form,
        ]);
    }
}

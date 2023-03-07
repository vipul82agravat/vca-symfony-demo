<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContacType;
use App\Factory\ContactFactory;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
    #[Route('/contact_list', name: 'app_contact_list')]
    public function listContact(Request $request,ContactRepository $contactRepository): Response
    {
       
        return $this->render('contact/list.html.twig', [
        ]);
    }
    #[Route('/contact_ajax_call', name: 'app_contact_ajax_call')]
    public function contactAjaxAction(Request $request,ManagerRegistry $doctrine): Response
    {
        //dd($request);

        $entityManager = $doctrine->getManager();
            $Contacts = $entityManager->getRepository(Contact
            ::class)->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
                $jsonData = array(); 
                $idx = 0;
                foreach($Contacts  as $contact ) { 
                    $temp = array(
                        'name' => $contact->getFirstname().'-'.$contact->getLastname(),  
                        'email' => $contact->getEmail(),
                        'message' => $contact->getNote(),  
                        'action' => '<a id = "con_delete" href = "#"  class="btn btn-primary">Delete</a>',  
                    );   
                $jsonData[$idx++] = $temp;  
                }
                return new JsonResponse($jsonData); 
         } else { 
            return $this->render('contact/list.html.twig', [
            ]);
         } 

       
    }
    #[Route('/contact_delete/{id}', name: 'app_contact_delete')]
    public function contactDeleteAction(Request $request,ManagerRegistry $doctrine,int $id): Response
    {
        $entityManager = $doctrine->getManager();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
                
                $id=$request->request->get('contact_id');
                $Contact = $entityManager->getRepository(Contact
                ::class)->find($id);
                
                $jsonData="Contact info is deleted";
                return new JsonResponse($jsonData); 

         } else { 
               
                $Contact = $entityManager->getRepository(Contact
                ::class)->find($id);
                $entityManager->remove($Contact);
                $entityManager->flush();
                if (!$Contact) {
                    throw $this->createNotFoundException(
                        'No User found for id '.$id
                    );
                }
                return $this->render('contact/list.html.twig', [
                ]);
         } 

       
    }
}

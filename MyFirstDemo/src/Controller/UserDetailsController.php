<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Type\UserAddressType;

class UserDetailsController extends AbstractController
{
    
    //user details render view page
    #[Route('/user/details', name: 'app_user_details')]
    public function index(): Response
    {
        return $this->render('user_details/index.html.twig', [
            'controller_name' => 'UserDetailsController',
        ]);
    }
     //get the all user address list
    #[Route('/user_address_list', name: 'user_address_list')]
    public function getUserAddressList(UserRepository $doctrine,AddressRepository $addressRepository) :Response
    {  
        
          //get query  for Address data form custom query for sql and builder
        $userAddress=$addressRepository->findAllByJoinedToAddress();
        
        return $this->render('users/user_address_list.html.twig', [
             'userAddress' => $userAddress,
         ]);
    }
    //Add  user  address
    #[Route('/add_user_address', name: 'add_user_address')]
    public function addUserAddress(Request $request,ManagerRegistry $doctrine) :Response
    {  
          
        
        $entityManager = $doctrine->getManager();
       

        $user = $entityManager->getRepository(User::class)->find(2);
        $userAddress= new Address();
        $userAddress->setHouseNumber('adsfasasf');
        //$userAddress->setUser('1');
        
        $form = $this->createForm(UserAddressType::class, $userAddress);
        
        //$form = $this->createForm(UserType::class, [
          //  'action' => $this->generateUrl('user_class_form'),
            //'method' => 'POST']);

       
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
            
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $userAddresss = $form->getData();
             $entityManager->persist($userAddress);
             
                
             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();
             // ... perform some action, such as saving the task to the database
            
             return $this->redirectToRoute('user_address_list');
         }
        return $this->render('users/user_form.html.twig', [
            'form' => $form,
        ]);

    }

    //get user information form parent class string function page render
    #[Route('/user_info', name: 'user_info')]
    public function UserInfo(UserController $user): Response
    {   
            $response=$user->string();
            
            return $response;
    }
    //get the user parent page call form child controller to prent userPage function
    #[Route('/user_parent_page', name: 'user_parent_page')]
    public function userPage(UserController $user): Response
    {   
            $response=$user->userPage();
            
            return $response;
    }
    // file download function get the dwonload functionlity form the user tables
    #[Route('/user_file_download', name: 'user_file_download')]
    public function download(UserController $user): Response
    {       $path="/path/to/some_file.pdf1";
            $response=$user->download($path);
            
            return $response;
    }

    
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Branch;
use App\Form\Type\BranchType;
use App\Repository\BranchRepository;
use Doctrine\Persistence\ManagerRegistry;

class BranchController extends AbstractController
{
    #[Route('/branch', name: 'app_branch')]
    public function index(): Response
    {
        return $this->render('branch/index.html.twig', [
            'controller_name' => 'BranchController',
        ]);
    }

    #[Route('/add_branch', name: 'app_add_branch')]
    public function addBranch(Request $request,BranchRepository $branchRepository,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $branch = new Branch();
        $form=$this->createForm(BranchType::class, $branch);
        $branch_name=$request->get('branch_name');
        
                $form->handleRequest($request);
               //using orm save data save useing orm doctrain with mutltiple value add for fornt end  it store inside the data base table with id
                // if ($form->isSubmitted() && $form->isValid()) {
                //     $i=1;
                //     $objects = array();
                //    foreach($branch_name as $key=>$branchnm)
                //    {
                //         echo $branchnm;
                //         echo "<br>";
                //         $branch = new Branch();
                //         $branch = $form->getData();
                //         $branch->setName($branchnm);
                //         $entityManager->persist($branch);
                //         $objects[] = $branch;
                        
                //         // actually executes the queries (i.e. the INSERT query)
                       
                //    }
                //    $entityManager->flush();
                   
                //     return $this->redirectToRoute('app_branch_list');
                // }

                //custom insert value inside the brnach and user value
                if (isset($branch_name) and $branch_name!="") {
                
                    $branch=$request->get('branch');
                    $user_id=$branch['user'];
                    $status=$branch['status'];
                    
                    $response=$branchRepository->saveBranch($branch_name,$user_id,$status);
                    if($response['status']==1){
                        
                        return $this->redirectToRoute('app_branch_list');
                    }else{
                    return $this->render('branch/add_branch_form.html.twig', [
                        'form' => $form
                    ]);
                    }    
                }      
        
        return $this->render('branch/add_branch_form.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/branch_list', name: 'app_branch_list')]
    public function list_Branch(Request $request,BranchRepository $branchRepository,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $userBranch = $entityManager->getRepository(Branch::class)->findAll();
       
            if (!$userBranch) {
                    throw $this->createNotFoundException(
                        'No  userBranch Record found '
                    );
             }
             
            
             
            $result=[];
            foreach($userBranch as $key=>$branch){
                    $result[$key]['id']=$branch->getId();
                    $result[$key]['name']=$branch->getName();
                    $result[$key]['user']=$branch->getUser()->getName();
            }
            
        return $this->render('branch/index.html.twig', [
            'userBranch'=>$result
        ]);
    }
    #[Route('/delete_branch/{id}', name: 'app_delete_branch')]
    public function delete_Branch(Request $request,BranchRepository $branchRepository,ManagerRegistry $doctrine,int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $getuserBranch = $entityManager->getRepository(Branch::class)->find($id);
       
            if (!$getuserBranch) {
                    throw $this->createNotFoundException(
                        'No  userBranch Record found '
                    );
             }
            
            
        $entityManager->remove($getuserBranch);
        $entityManager->flush();   

        $userBranch = $entityManager->getRepository(Branch::class)->findAll();
        $result=[];
            foreach($userBranch as $key=>$branch){
                
                    $result[$key]['id']=$branch->getId();
                    $result[$key]['name']=$branch->getName();
                    $result[$key]['user']=$branch->getUser()->getName();
            }
        $this->addFlash(
            'notice',
            'Your Branch was deleted!'
        );
        return $this->render('branch/index.html.twig', [
            'userBranch'=>$result
        ]);
    }


   
}

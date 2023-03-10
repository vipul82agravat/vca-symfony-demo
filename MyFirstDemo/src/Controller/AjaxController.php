<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

class AjaxController extends AbstractController
{
    #[Route('/ajax', name: 'app_ajax')]
    public function index(): Response
    {
            
            return $this->render('ajax/index.html.twig', [
            'controller_name' => 'AjaxController',
        ]);
    }
    #[Route('/ajax_call', name: 'app_ajax_call')]
    public function ajaxAction(Request $request): Response
    {
        //dd($request);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
                $jsonData = array();  
                $temp = array(
                    'name' => 'vipul',  
                    'address' => 'raval',  
                );   
                $jsonData = $temp;  
                return new JsonResponse($jsonData); 
         } else { 
            return $this->render('ajax/ajax.html.twig', [
                'controller_name' => 'AjaxController',
            ]);
         } 

       
    }
    #[Route('/ajax_call_request', name: 'app_ajax_call_request')]
    public function ajaxRequestAction(Request $request): Response
    {
        
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $name=$request->request->get('request_data');
                    
                    $jsonData = $name;  
                    return new JsonResponse($jsonData); 
         } else { 
            return $this->render('ajax/ajax_request.html.twig');
         } 

       
    }
}

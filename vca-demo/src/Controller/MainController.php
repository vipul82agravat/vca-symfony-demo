<?php
// src/Controller/MainController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'mobile_homepage', host: 'https://127.0.0.1:8000/sub')]
    public function mobileHomepage(): Response
    {
        // ...
        $msg="Sub-Domain Routing Example";
        dd($msg);
    }

    //[Route('/home', name: 'homepage')]
    #[Route('/home', name: 'homepage', stateless: true)]
    public function homepage(): Response
    {
        // ...
        $msg="Welcome Routing Example";
        dd($msg);
    }
}
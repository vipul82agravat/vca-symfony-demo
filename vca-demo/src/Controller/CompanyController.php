<?php
// src/Controller/CompanyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
        #[Route(path: [
            'en' => '/about-us',
            'nl' => '/over-ons'
            ], name: 'about_us')]
        public function about(): Response
        {
            // ...
            $msg="Localized Routes Example";
            dd($msg);
        }
}
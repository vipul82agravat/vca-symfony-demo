<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class HomeController extends AbstractController
{
   
    /*
     * return the result in to the view file
     */
    public function index():  Response
    {
        $string = "Well-come to home page";

        return $this->render('Home/index.html.twig', [
            'string' => $string,
        ]);
    }
    #[Route('/test_url', name: 'test_url')]
    public function testUrl(): RedirectResponse
    {
        dd(7);
    }
    public function test(): Response
    {
        dd("test");
    }
}

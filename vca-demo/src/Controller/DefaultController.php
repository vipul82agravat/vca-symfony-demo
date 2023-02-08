<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(
    '/contact_condition',
    name: 'contact_condition',
  //  condition: "context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/firefox/i'",
        // expressions can also include config parameters:
        // condition: "request.headers.get('User-Agent') matches '%app.allowed_browsers%'"
    )]
    public function contact(): Response
    {
        // ...
        $msg="Get data base on condition given on routes";
        dd($msg);
    }

    #[Route(
    '/posts_condition/{id}',
    name: 'post_show_condition',
        // expressions can retrieve route parameter values using the "params" variable
   // condition: "params['id'] < 1000"
    )]
    public function showPost(int $id): Response
    {
        // ... return a JSON response with the post
        $msg="Get data base on condition given on routes for id is less then 1000";
        dd($msg);
    }

    //Slash Characters in Route Paramete
    #[Route('/share/{token}', name: 'share', requirements: ['token' => '.+'])]
    public function share($token): Response
    {
        // ...
        $msg="Slash Characters in Route Parametersc ".$token;
        dd($msg);
    }
}
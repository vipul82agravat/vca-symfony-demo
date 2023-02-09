<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


// ...
class SessionController extends AbstractController
{

    #[Route('/session', name: 'session')]
    public function session(Request $request): Response
    {
        $session = $request->getSession();
        dd($session);
    }
     #[Route('/set_session', name: 'set_session')]
    public function set_session(Request $request): Response
    {
         $session = $request->getSession();
         $user_id=$session->set('user_id', '2');
        dd($user_id);
    }
      #[Route('/get_session', name: 'get_session')]
    public function get_session(Request $request): Response
    {
         $session = $request->getSession();
         $user_id = $session->get('user_id');
         $filters = $session->get('filters', []);
         dd($user_id,$filters);
    }
}

<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\SessionService;

// ...
class SessionController extends AbstractController
{

  // session is mange request classs get the session data
    #[Route('/session', name: 'session')]
    public function session(Request $request): Response
    {
        $session = $request->getSession();
        dd($session);
    }

  // session is mange request classs set the session data
     #[Route('/set_session', name: 'set_session')]
    public function set_session(Request $request): Response
    {
         $session = $request->getSession();
         $user_id=$session->set('user_id', '2');
        dd($user_id,'Session Set SuccessFully');
    }

  // session is mange request classs get the session data
      #[Route('/get_session', name: 'get_session')]
    public function get_session(Request $request): Response
    {
         $locale = $request->getLocale();

         $session = $request->getSession();
         $user_id = $session->get('user_id');
         $filters = $session->get('filters', []);
         dd($user_id,$filters,'Session Get SuccessFully');
    }

  // session is mange request classs get the session useing Service class
    #[Route('/get_session_service', name: 'get_session_service')]
    public function get_session_service(SessionService $session): Response
    {
         $sessionDetails = $session->getSessionData();
         $user_id = $sessionDetails->get('user_id');
         $user_name = $sessionDetails->get('user_name',[]);
         dd($sessionDetails,$user_id,$user_name,'Session Service call SuccessFully and return data');
    }

  // session is mange request classs set the session data using Service class
    #[Route('/set_session_service', name: 'set_session_service')]
    public function set_session_service(SessionService $session): Response
    {
         $sessionDetails = $session->setSessionData('user_name', 'vipul');
         dd($sessionDetails,'Session Service call SuccessFully and return set data');
    }

    // session is mange session and set the messge in flush and get this message in view page index.twig
    #[Route('/set_session_view', name: 'set_session_view')]
    public function set_session_view(SessionService $session): Response
    {

//       $getCreated=$session->getMetadataBag()->getCreated();
//       $getLastUsed=$session->getMetadataBag()->getLastUsed();
//        dd($getCreated,$getLastUsed);
         $this->addFlash(
            'notice',
            'Your changes were saved! '
        );
         
         return $this->render('session/index.html.twig');
    }
      #[Route('/encrypt_session', name: 'encrypt_session')]
    public function encrypt_session_data(): Response
    {

          ;

//       $getCreated=$session->getMetadataBag()->getCreated();
//       $getLastUsed=$session->getMetadataBag()->getLastUsed();
//        dd($getCreated,$getLastUsed);
         $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

         return $this->render('session/index.html.twig');
    }
    
    #[Route('/encrypt_session1', name: 'encrypt_session1')]
    public function encrypt_session_data1(): Response
    {


//       $getCreated=$session->getMetadataBag()->getCreated();
//       $getLastUsed=$session->getMetadataBag()->getLastUsed();
//        dd($getCreated,$getLastUsed);
         $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

         return $this->render('session/index.html.twig');
    }
}

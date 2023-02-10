<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use App\Service\MessageGenerator;
use App\Service\RandomNumberGenerator;
use App\Service\GenrateUrlService;
use App\Service\SiteManager;
use App\Service\InjectMessageGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


// ...
class ServiceDemoController extends AbstractController
{

    #[Route('/get_service', name: 'get_service')]
    public function new(MessageGenerator $messageGenerator): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new MessageGenerator and pass it to you!
        // ...

        $message = $messageGenerator->getHappyMessage();
        $name=$messageGenerator->name();

        dd($message,$name);
    }
     #[Route('/get_number', name: 'get_number')]
    public function number(RandomNumberGenerator $getnumber): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new RandomNumberGenerator and pass it to you!
        // ...

        $rand_number = $getnumber->getNumber();
        dd($rand_number);
    }
    #[Route('/get_url', name: 'get_url')]
    public function url(GenrateUrlService $geturl): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new RandomNumberGenerator and pass it to you!
        // ...

        $url_response = $geturl->getUrl();
        dd($url_response);
    }

     #[Route('/get_service_param', name: 'get_service_param')]
    public function getparams(SiteManager $getparams): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new RandomNumberGenerator and pass it to you!
        // ...

        $params_response = $getparams->getParams();
        dd($params_response);
    }

     #[Route('/get_service_inject_param', name: 'get_service_inject_param')]
    public function getInjectparams(InjectMessageGenerator $getInjectparams): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new RandomNumberGenerator and pass it to you!
        // ...

        $params_response = $getInjectparams->getInjectMessage();
        dd($params_response);
    }
}

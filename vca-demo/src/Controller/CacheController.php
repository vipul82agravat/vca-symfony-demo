<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CacheService;
use App\Service\SessionService;

// ...
class CacheController extends AbstractController
{
    //special attributes with the same nam

        #[Route('/my_redis_cache', name: 'my_redis_cache')]
        public function myRedisCache(Request $request): Response
        {
            dd($request);
            $result="";
            $msg="Well come to my Redis cache example";
            dd($result,$msg);
        }

     // session is mange request classs get the session useing Service class
        #[Route('/my_cache_data', name: 'my_cache_data')]
        public function getCache(SessionService $session): Response
        {
            $sessionDetails = $session->getSessionData();
            $user_id = $sessionDetails->get('user_id');
            $user_name = $sessionDetails->get('user_name',[]);
            dd($sessionDetails,$user_id,$user_name,'Session Service call SuccessFully and return data');
        }
}

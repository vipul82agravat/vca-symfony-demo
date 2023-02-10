<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TemplateController extends AbstractController
{

    #[Route('/tiwg_render_view', name: 'tiwg_render_view')]
    public function twig_view(Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $routeParameters = "123";
        $arr=['name'=>$routeName,'routeParameters'=>$routeParameters];
        //dd($routeName,$routeParameters,$allAttributes);

        return $this->render('twig/user.html.twig',['params'=>$arr]);
        // ...

    }
         #[Route('/tiwg_user_info', name: 'tiwg_user_info')]
        public function userArticles(int $max = 3): Response
        {
            // get the recent articles somehow (e.g. making a database query)
            $articles = ['1', '2', '3'];

            return $this->render('twig/user_info.html.twig', [
                'articles' => $articles
            ]);
        }
}
?>

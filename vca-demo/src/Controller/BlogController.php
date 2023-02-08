<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlogController extends AbstractController
{

    //Extra Parameters
    #[Route('/blog_extra/{page}', name: 'blog_index', defaults: ['page' => 1, 'title' => 'Hello world!'])]
    public function index(int $page, string $title): Response
    {
        // ...
        $msg="Welcome to Extra Parameters in Routes Exmple ".$page.'-'.$title;
        dd($msg);
    }
    #[Route('/blog', name: 'blog_list')]
    public function list(): Response
    {
        $msg="Welcome to Attributes Routes Exmple";
        dd($msg);
    }

    /* php routes example
     */
    public function list_php(): Response
    {
        $msg="Welcome to Routes PHP Exmple";

        dd($msg);
    }

    /*
     * rotues form rotues.yml file
     */
    public function list_yml(): Response
    {
        $msg="Welcome to Routes YML Exmple";
        dd($msg);
    }

    //Route Parameters
    #[Route('/blog/{slug}/{slug1}', name: 'blog_show')]
    public function show(string $slug,string $slug1): Response
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /blog/yay-routing, then $slug='yay-routing'

        $msg="Welcome to Routes Parameters Exmple your slug is =".$slug."-".$slug1;
        dd($msg);
        // ...
    }

    //only accept the number value using d+
    //[Route('/list_page/{page}', name: 'blog_page_list', requirements: ['page' => '\d+'])]
    #[Route('/list_page/{page<\d+>}', name: 'blog_page_list')]
    public function list_page(int $page): Response
    {
        // ...
        $msg="Welcome to Routes Parameters  requirements Exmple your slug is =".$page;
        dd($msg);
    }

    //Optional Parameters deafult values
    #[Route('/list_deafult_page/{page}', name: 'blog_page_deafult_list', requirements: ['page' => '\d+'])]
    public function list_deafult_page(int $page=1): Response
    {
        // ...
        $msg="Welcome to Routes Parameters Deafult Exmple your page is =".$page;
        dd($msg);
    }

    //Inlined in each parameter
    #[Route('/list_in_deafult_page/{page<\d+>?1}', name: 'blog_in_deafultlist')]
    public function list_in_deafult_page(int $page): Response
    {
        // ...
        $msg="Welcome to Routes Parameters Inlined Deafult Exmple your page is =".$page;
        dd($msg);
    }

    /**
     * This route could not be matched without defining a higher priority than 0.
     */
    #[Route('/blog/priority_list', name: 'blog_priority_list', priority: 1)]
    public function prioritylist(): Response
    {
        // ...
        $msg="Welcome to Priority Parameter";
        dd($msg);
    }

    #[Route('/blog_request/{id}', name: 'blog_request_list')]
    public function request_list(int $id,Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $routeParameters = $request->attributes->get('_route_params');

        // use this to get all the available attributes (not only routing ones):
        $allAttributes = $request->attributes->all();

        dd($routeName,$routeParameters,$allAttributes);

        // ...
    }

    #[Route('/blog_request_view/{id}', name: 'blog_request_list_view')]
    public function request_list_view(int $id,Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $routeParameters = $request->attributes->get('_route_params');

        // use this to get all the available attributes (not only routing ones):

        $allAttributes = $request->attributes->all();
        $arr=['name'=>$routeName,'routeParameters'=>$routeParameters['id']];
        //dd($routeName,$routeParameters,$allAttributes);
        return $this->render('request/info.html.twig',['params'=>$arr]);
        // ...
    }

    #[Route('/generate_url', name: 'generate_url_list')]
    public function generate_Url(): Response
    {
        // generate a URL with no route arguments
        $signUpPage = $this->generateUrl('blog_list');

        // generate a URL with route arguments
        $userProfilePage = $this->generateUrl('blog_request_list_view', [
            'id' => 1,
        ]);

        // generated URLs are "absolute paths" by default. Pass a third optional
        // argument to generate different URLs (e.g. an "absolute URL")
        $signUpPage_ab = $this->generateUrl('blog_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

        // when a route is localized, Symfony uses by default the current request locale
        // pass a different '_locale' value if you want to set the locale explicitly
        $signUpPageInDutch = $this->generateUrl('blog_list', ['_locale' => 'nl']);

        $query_string=$this->generateUrl('blog_list', ['page' => 2, 'category' => 'Symfony']);
            // the 'blog' route only defines the 'page' parameter; the generated URL is:
            // /blog/2?category=Symfony


        dd( $signUpPage,$userProfilePage,$signUpPage_ab,$signUpPageInDutch,$query_string);
        // ...
    }

}
?>
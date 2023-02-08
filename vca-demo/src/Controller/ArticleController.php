<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// ...
class ArticleController extends AbstractController
{
    //special attributes with the same nam
    #[Route(
        path: '/articles/{_locale}/search.{_format}',
        locale: 'en',
        format: 'html',
        requirements: [
        '_locale' => 'en|fr',
        '_format' => 'html|xml',
        ],
        )]
    public function search(): Response
    {
        $msg="special paramters example";
        dd($msg);
    }
}
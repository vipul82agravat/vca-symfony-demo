<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// ...
#[Route('/groupblog', requirements: ['_locale' => 'en|es|fr'], name: 'blog_')]

class GroupController extends AbstractController
{
    #[Route('/{_locale}', name: 'index')]
    public function index(): Response
    {
        // ...
        $msg="Route Groups and Prefixes";
        dd($msg);
    }

    #[Route('/{_locale}/posts/{slug}', name: 'show_post')]
    public function show(string $slug="v"): Response
    {
        // ...
        $msg="Route Groups and Prefixes slug ".$slug;
        dd($msg);
    }
    #[Route('/{_locale}/test', name: 'show')]
    public function test(): Response
    {
        // ...
        $msg="Route Groups and Prefixes Test";
        dd($msg);
    }
}
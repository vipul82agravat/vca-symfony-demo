<?php
// src/Service/SomeService.php
namespace App\Service;

use Twig\Environment;

class PageService
{
    private $twig;

    public function __construct(Environment $twig)
    {
        echo "PageService is call";
        echo "<br>";
        $this->twig = $twig;
    }

    public function pageRender()
    {
        // ...
        return 'pageRender';
        $htmlContents = $this->twig->render('users/index.html.twig', [
            'category' => 'vipul',
            'promotions' => ['BCA', 'MCA'],
        ]);
        
    }
}
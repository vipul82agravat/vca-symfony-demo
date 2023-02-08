<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
    /*
     [Route('/lucky/string', name: 'string_list')]
    */
    public function string():  Response
    {
        $string = "vipul";

        return new Response($string);
    }

    public function test():  Response
    {
        $string = "test";

        return new Response($string);
    }
    /*
     * return the result in to the view file
     */
    public function template():  Response
    {
        $string = "test";

        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
}
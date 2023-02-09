<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class LuckyController extends AbstractController
{
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    #[Route('/lucky/number_log/{max}')]
    public function number_log(int $max, LoggerInterface $logger): Response
    {
        // ...
       $logger->info('We are logging!');
        dd($logger);
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
    #[Route('/lucky/number_autowire/{max}')]
    public function numberAutowire(
        int $max,

        // inject a specific logger service
        #[Autowire(service: 'monolog.logger.request')]
        LoggerInterface $logger,

        // or inject parameter values
        #[Autowire('%kernel.project_dir%')]
        string $projectDir
    ): Response
    {
        dd($logger);
        $logger->info('We are logging!');
        // ...
    }
}
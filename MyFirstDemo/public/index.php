<?php

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

// init service container 
$containerBuilder = new ContainerBuilder();

// // add service into the service container 
// $containerBuilder->register('demo.service', '\Services\DemoService');


// // fetch service from the service container 
// $demoService = $containerBuilder->get('demo.service');
// dd($demoService);
// echo $demoService->helloWorld();
// dd(5);
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

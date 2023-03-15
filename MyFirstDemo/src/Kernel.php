<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\EventDispatcher\DependencyInjection\AddEventAliasesPass;

use Product\Event\ProductCreateEvent;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    // public function getCharset(): string
    // {
    //     return 'ISO-8859-1';
    // }
    protected function build(ContainerBuilder $containerBuilder)
    {
        
        $containerBuilder->addCompilerPass(new AddEventAliasesPass([
            ProductCreateEvent::class => 'my_custom_event',
        ]));
    }
    // public function registerBundles(KernelInterface $container): iterable{
        
    //     $bundles = array( 
    //         // ... 
    //         // register your bundle 
    //         new Acme\TestBundle\AcmeTestBundle(), 
    //      ); 
    //      return $bundles; 
    
    // }
}

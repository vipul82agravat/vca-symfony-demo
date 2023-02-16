<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    // public function getCharset(): string
    // {
    //     return 'ISO-8859-1';
    // }
    // public function getProjectDir(): string
    // {
    //     return \dirname(__DIR__);
    // }
}

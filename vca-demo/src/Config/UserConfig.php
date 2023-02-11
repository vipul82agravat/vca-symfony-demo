<?php
// src/Service/FormatterManager.php
namespace App\Config;
use App\Service\SiteManager;
use Symfony\Component\DependencyInjection\Definition;

class UserConfig
{
    // ...
    public function __construct()
    {
       $definition = new Definition(SiteManager::class,['vv']);
       // override the class
       $definition->setClass(SiteManager::class);
       $class = $definition->getClass();
       $file=$definition->setFile('/src/path/to/file/foo.php');
       $methodCalls = $definition->getMethodCalls();

    }
    public function getEnabledFormatters(): array
    {
        // code to configure which formatters to use
        $enabledFormatters = ["My Formatter"];//[...];

        // ...

        return $enabledFormatters;
    }
    public function configure(): string
    {
        return "1";
    }
    public function __invoke(){
        return 1;
    }
}

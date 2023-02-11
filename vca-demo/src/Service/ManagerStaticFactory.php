<?php
// src/Service/FormatterManager.php
namespace App\Service;
use App\Service\FactorySiteManager;

class ManagerStaticFactory
{
     public static function createSiteManager(): FactorySiteManager
    {
        $siteManager = new FactorySiteManager();

        // ...

        return $siteManager;
    }
}

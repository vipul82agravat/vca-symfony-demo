<?php
// src/Service/FormatterManager.php
namespace App\Service;

class FormatterManager
{
    // ...
    public function __construct()
    {
        echo 2;
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

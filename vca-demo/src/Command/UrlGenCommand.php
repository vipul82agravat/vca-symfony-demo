<?php
// src/Command/SomeCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
// ...

class UrlGenCommand extends Command
{
    public function __construct(private RouterInterface $router)
    {
        parent::__construct();
    }

protected function execute(InputInterface $input, OutputInterface $output): int
{
    // generate a URL with no route arguments
    $signUpPage = $this->router->generate('blog_list');

    // generate a URL with route arguments
    $userProfilePage = $this->router->generate('blog_list', [
        'username' => $user->getUserIdentifier(),
    ]);

    // generated URLs are "absolute paths" by default. Pass a third optional
    // argument to generate different URLs (e.g. an "absolute URL")
    $signUpPage = $this->router->generate('blog_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

    // when a route is localized, Symfony uses by default the current request locale
    // pass a different '_locale' value if you want to set the locale explicitly
    $signUpPageInDutch = $this->router->generate('blog_list', ['_locale' => 'nl']);

    // ...
}
}
<?php
// src/Service/SomeService.php
namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlGenService
{
    public function __construct(private UrlGeneratorInterface $router)
    {
    }

        public function getUrl()
        {
            // ...

            // generate a URL with no route arguments
            $signUpPage = $this->router->generate('blog_list');

            // generate a URL with route arguments
            $userProfilePage = $this->router->generate('blog_request_list_view', [
                'id' => 1,//$user->getUserIdentifier(),
            ]);

            // generated URLs are "absolute paths" by default. Pass a third optional
            // argument to generate different URLs (e.g. an "absolute URL")
            $signUpPage = $this->router->generate('blog_list', [], UrlGeneratorInterface::ABSOLUTE_URL);

            // when a route is localized, Symfony uses by default the current request locale
            // pass a different '_locale' value if you want to set the locale explicitly
            $signUpPageInDutch = $this->router->generate('blog_list', ['_locale' => 'nl']);
        }
}
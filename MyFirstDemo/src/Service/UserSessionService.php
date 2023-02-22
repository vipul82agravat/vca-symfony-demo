<?php 
namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;

class UserSessionService
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        // Accessing the session in the constructor is *NOT* recommended, since
        // it might not be accessible yet or lead to unwanted side-effects
        // $this->session = $requestStack->getSession();
    }

    public function getSession($key)
    {
        $session = $this->requestStack->getSession($key);
        return $session;
        // ...
    }
    public function setSession($key,$value)
    {
        $session = $this->requestStack->setSession($key,$value);

        // ...
    }
}
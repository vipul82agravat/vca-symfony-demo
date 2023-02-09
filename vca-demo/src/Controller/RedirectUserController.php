<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// ...
class RedirectUserController extends AbstractController
{

    //special attributes with the same nam
    #[Route(
        path: '/user/{_locale}/search.{_format}',
        locale: 'en',
        format: 'html',
        requirements: [
        '_locale' => 'en|fr',
        '_format' => 'html|xml',
        ],
        )]
    public function search(): Response
    {
        $msg="special paramters example";
        dd($msg);
    }
    #[Route('/redirect_url', name: 'redirect_url_list')]
    public function index(): RedirectResponse
    {
        // redirects to the "homepage" route
        return $this->redirectToRoute('homepage');
    }

    #[Route('/redirect_url/permanent', name: 'redirect_url_permanent')]
    public function redirect_permanent(): RedirectResponse
    {
        // redirectToRoute is a shortcut for:
        // return new RedirectResponse($this->generateUrl('homepage'));

        // does a permanent HTTP 301 redirect
        return $this->redirectToRoute('homepage', [], 301);
    }
    #[Route('/redirect_url/constants', name: 'redirect_url_constants')]
    public function redirect_constants(): RedirectResponse
    {
        // if you prefer, you can use PHP constants instead of hardcoded numbers
        return $this->redirectToRoute('homepage', [], Response::HTTP_MOVED_PERMANENTLY);
    }
    #[Route('/redirect_url/parameters', name: 'redirect_url_parameters')]
    public function parameters(): RedirectResponse
    {
        // redirect to a route with parameters
        $url_gern=$this->generateUrl('app_lucky_number', ['max' => 10]);
        return $this->redirectToRoute('app_lucky_number', ['max' => 10]);
    }
    #[Route('/redirect_url/query', name: 'redirect_url_querystring')]
    public function querystring(Request $request): RedirectResponse
    {

        // redirects to a route and maintains the original query string parameters
        return $this->redirectToRoute('blog_show', $request->query->all());
    }
    #[Route('/redirect_url/currentroute', name: 'redirect_url_currentroute')]
    public function currentroute(Request $request): RedirectResponse
    {
        // redirects to the current route (e.g. for Post/Redirect/Get pattern):
        return $this->redirectToRoute($request->attributes->get('_route'));

    }
    #[Route('/redirect_url/externally', name: 'redirect_url_externally')]
    public function externally(): RedirectResponse
    {    // redirects externally
        return $this->redirect('http://symfony.com/doc');
    }

    #[Route('/redirect_url/exception', name: 'redirect_url_exception')]
    public function userException(): RedirectResponse
    {    // redirects externally

        $product ="";
        if (!$product) {
            throw new \Exception('Something went wrong!');
            throw $this->createNotFoundException('The product does not exist');
             // the above is just a shortcut for:
            // throw new NotFoundHttpException('The product does not exist');
        }
        //return $this->redirect('http://symfony.com/doc');
    }
    #[Route('/access_conf/value', name: 'access_conf')]
    public function accessConf(): RedirectResponse
    {
        $contentsDir = $this->getParameter('kernel.project_dir').'/contents';
        $email = $this->getParameter('app.admin_email').'/contents';
        dd($contentsDir,$email);
    }

    #[Route('/json_response/value', name: 'json_response')]
    public function responseJson(): JsonResponse
    {
        // returns '{"username":"jane.doe"}' and sets the proper Content-Type header
        return $this->json(['username' => 'jane.doe']);

        // the shortcut defines three optional arguments
        // return $this->json($data, $status = 200, $headers = [], $context = []);
    }
    #[Route('/download/value', name: 'download')]
    public function download(): BinaryFileResponse
    {
        // send the file contents and force the browser to download it
        return $this->file('/home/vipula/Documents/DFD_new.odt');
    }
    #[Route('/download_arguments/value', name: 'downloadarguments')]
    public function downloadArguments(): BinaryFileResponse
    {
        // load the file from the filesystem
        $file = new File('/home/vipula/Documents/DFD_new.odt');

        return $this->file($file);

        // rename the downloaded file
        return $this->file($file, 'custom_name.pdf');

        // display the file contents in the browser instead of downloading it
        return $this->file('invoice_3241.pdf', 'my_invoice.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
    #[Route('/session/value', name: 'session')]
    public function session(Request $request): Response
    {
        $session = $request->getSession();
        dd($session);
//         return $this->addFlash(
//             'notice',
//             'Your changes were saved!'
//         );
    }
}

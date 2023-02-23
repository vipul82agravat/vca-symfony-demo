<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Service\PageService;
use App\Service\MessageGenerator;
use App\Service\SiteUpdateManager;
use App\Service\UserSessionService;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Type\UserType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\UsertCreateEvent;
use App\Event\UserUpdateEvent;
use App\Event\UserDeleteEvent;
use App\Event\UserEventSubscriber;

class UserController extends AbstractController
{
    
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

        /**
         * @Route("/")
         */
        public function userindex(TranslatorInterface $translator)
        {
            $contents = $this->renderView('users/menu.html.twig', [
                'category' => '121',
                'promotions' => ['0', '1'],
            ]);
    
            return new Response($contents);
        }

    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/list_user', name: 'list_user')]
    public function listUSer(ManagerRegistry $doctrine) :Response
    {   
        $user = $doctrine->getRepository(User::class)->findAll();
        
        if (!$user) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        echo '<a href="../../user_index">Back</a>';
        foreach($user as $us){
            echo "<br>";
            print_r($us);
            // echo $us->name.'-'.$us->email;
            echo "<br>";
            echo "<hr>";
        }
       
        return new Response('user listing data:');
    }

    //custom quey for get the all user after the match user id for user table 
    #[Route('/get_user_custom_query/{id}', name: 'get_user_query')]
    public function getUSerCustomQuery(UserRepository $doctrine,int $id) :Response
    {   
        //findAllUser custom funstion query bulider
        $user = $doctrine->findAllUser($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        foreach($user as $us){
            echo "<br>";
            print_r($us);
            // echo $us->name.'-'.$us->email;
            echo "<br>";
            echo "<hr>";
        }
        echo '<a href="../../user_index">Back</a>';
        return new Response('user listing data:');
    }
    //sql custom quey for get the all user after the match user id for user table 
    #[Route('/get_user_custom_sql_query/{id}', name: 'get_user_custom_sql_query')]
    public function getUSerCustomSQlQuery(UserRepository $doctrine,int $id=1) :Response
    {   
        //findAllUser custom funstion  SQL query 
        $user = $doctrine->findAllUserSql($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        foreach($user as $us){
            echo "<br>";
            print_r($us['name']);
            echo "|";
            print_r($us['email']);
            echo "<br>";
            echo "<hr>";
          
        }
        echo '<a href="../../user_index">Back</a>';
        return new Response('user listing data:');
    }

    #[Route('/add_user', name: 'create_user')]
    public function createUSer(ManagerRegistry $doctrine) :Response
    {
        $entityManager = $doctrine->getManager();

        $user= new User();
        $user->setName('vipul_Dev');
        $user->setEmail('vipul@gmail.com');
        $user->setGender('Male');
        $user->setDesciption('text');
        $user->setStatus(1);

        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        echo '<a href="../../user_index">Back</a>';
        echo "<br>";  
        return new Response('Saved new User with id '.$user->getId());
    }

    //using add_user_repo save user data usgin  UserRepository
    #[Route('/add_user_repo', name: 'create_user_repo')]
    public function createUSerRepo(UserRepository $userRepository): Response
    {
        $user= new User();
        $user->setName('vipul_Dev_ff');
        $user->setEmail('vipulf@gmail.com');
        $user->setStatus(1);

        $userRepository->save($user,true);
       
        // ...
        echo '<a href="../../user_index">Back</a>';
        echo "<br>";  
        return new Response('Saved new User with id '.$user->getId());

    }

    #[Route('/add_user_valid', name: 'create_user_valid')]
    public function createUSerValidation(ValidatorInterface $validator): Response
    {
        $user= new User();
        $user->setName('vipul_Dev');
        $user->setEmail('vipul@gmail.com');
        $user->setStatus(1);


        // ...

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

    }

    #[Route('/edit_user/{id}', name: 'update_user')]
    public function editUser(ManagerRegistry $doctrine,int $id=5) :Response
    {
            $entityManager = $doctrine->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException(
                    'No user found for id '.$id
                );
            }

            $user->setName('Dev New Update');
            $entityManager->flush();

            echo '<a href="../../user_index">Back</a>';
            echo "<br>";  
        return new Response('Update  User with id '.$user->getId());
        // return $this->redirectToRoute('product_show', [
        //     'id' => $user->getId()
        // ]);

    }

    #[Route('/delete_user/{id}', name: 'delete_user')]
    public function deleteUser(ManagerRegistry $doctrine,int $id=1) :Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
       
        echo '<a href="../../user_index">Back</a>';
        echo "<br>"; 

        return new Response('Delete User with id '.$id);
    }
    #[Route('/user_map/{id}')]
    public function show(#[MapEntity] 
            User $user): Response {
        // use the ProduUserct!
        // ...
        dd($user);
    }

    //check Fetch Automatically

    /**
     * Fetch via primary key because {id} is in the route.
     */
    #[Route('/user_auto/{id}')]
    public function showByPk(User $user,int $id): Response
    {
        return new Response('user set id '.$id);
    }

    /**
     * Perform a findOneBy() where the slug property matches {slug}.
     */
    #[Route('/user_auto_slug/{slug}')]
    public function showBySlug(string $slug): Response
    {
        return new Response('user set string '.$slug);
    }

    public function number(LoggerInterface $logger): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    public function string(): Response
    {
        $string ="vipul";

        return $this->render('users/string.html.twig', [
            'string' => $string,
        ]);
    }

    //https://127.0.0.1:8000/user/en/search.html
    public function search(): Response
    {
        $string ="vipul";

        return $this->render('users/string.html.twig', [
            'string' => $string,
        ]);
    }

    //https://127.0.0.1:8000/user_params/2
    public function extraParams(Request $request,int $page=1): Response
    {
        $routeName = $request->attributes->get('_route');
        $routeParameters = $request->attributes->get('_route_params');
        dd($routeName,$routeParameters,$request,$page);
    }

     //Localized Routes 
     public function about(): Response
     {
        return new Response(
            '<html><body>Lucky number: About</body></html>'
        );
     }

     //Generating URLs
     public function generatingUrl(): Response
     {

        $list_user = $this->generateUrl('list_user');
        
        $list_user_full = $this->generateUrl('list_user', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $list_user_full_paams = $this->generateUrl('list_user', ['_locale' => 'nl']);
        
        echo '<a href="../../user_index">Back</a>';
        echo "<br>"; 

        return new Response(
            '<html><body>Url generate :'.$list_user.'<br>Full Url generate :'.$list_user_full.'<br>Paramter Url generate :'.$list_user_full.'</body></html>'
        );
     }

     //Redirecting URLs
     #[Route('/redirectUrl',name:"redirectUrl")]
    public function redirectUrl(Request $request): Response
     {

        return $this->redirectToRoute('list_user');

        //  // redirects to a route and maintains the original query string parameters
       // return $this->redirectToRoute('list_user', $request->query->all());

        // // redirects to the current route (e.g. for Post/Redirect/Get pattern):
        //return $this->redirectToRoute($request->attributes->get('_route'));

        // // redirects externally
         //return $this->redirect('http://symfony.com/doc');
     }
     //Streaming File Responses
     #[Route('/file_download')]
    public function download(): BinaryFileResponse
    {
        // send the file contents and force the browser to download it
        return $this->file('/path/to/some_file.pdf');
    }

    //tiwg useing renderView
    #[Route('/user_page',name:'user_page')]
    public function userPage(){

        $contents = $this->renderView('users/index.html.twig', [
            'category' => '121',
            'promotions' => ['0', '1'],
        ]);

        return new Response($contents);
    }
    //service paramtes 
    #[Route('/user_service_params',name:'user_service_params')]
    public function userPageService(PageService $pageservice): Response
    {
            $adminEmail = $this->getParameter('app.admin_email');
            dd($adminEmail);
    }
    // service inject
    #[Route('/user_serivce_message',name:'user_serivce_message')]
    public function userServiceMessage(MessageGenerator $messageGenerator): Response
    {
            $message = $messageGenerator->getHappyMessage();
            return new Response(
                '<html><body> Generate Message :'.$message.'</body></html>'
            );
           
    }
     //mutiple service inject
    #[Route('/user_serivce_mutltiple',name:'user_serivce_mutltiple')]
    public function userServiceMultitple(MessageGenerator $messageGenerator,LoggerInterface $logger): Response
    {       
            $msg= $logger->info('About to find a happy message!');
            
            $message = $messageGenerator->getHappyMessage();
            return new Response(
                '<html><body> Generate Message :'.$message.'</body></html>'
            );
           
    }
     //service  argument
     #[Route('/user_serivce_argument',name:'user_serivce_argument')]
     public function userServiceArgument(SiteUpdateManager $siteUpdateManager,LoggerInterface $logger): Response
     {       
             $message = $siteUpdateManager->notifyOfParams();
             echo '<a href="../../user_index">Back</a>';
             echo "<br>"; 
             return new Response(
                 '<html><body> Generate Message :'.$message.'</body></html>'
             );
            
     }

    //get with Seesion service 
    #[Route('/getSession',name:'getSession')]
    public function getSession(UserSessionService $session): Response
    {
        $attribute = $session->getSession('attribute-name');
        echo '<a href="../../user_index">Back</a>';
        echo "<br>"; 
        dd($attribute);
        // ...
    }

    //get seesion with normal request
    #[Route('/getSession_request',name:'getSession_request')]
    public function getSessionRequest(Request $request): Response
    {
        $session = $request->getSession();
        $attribute = $session->get('attribute-name');
        dd($attribute);
        // ...
    }

     //set with Seesion service 
     #[Route('/setSession',name:'setSession')]
     public function setSession(UserSessionService $session): Response
     {
         $session = $session->setSession('key-name', 'vipul-value');

         return new Response(
            '<html><body> Session set successfuly</body></html>'
        );
         // ...
     }
     
     //set seesion with normal request
     #[Route('/setSession_request',name:'setSession_request')]
     public function setSessionRequest(Request $request): Response
     {
        $session = $request->getSession();
        $session->set('attribute-name', 'attribute-value');
        return new Response(
            '<html><body> Session set successfuly</body></html>'
        );
        // ...
     }
     //set seesion flush message     
     #[Route('/setMessageRequest',name:'setMessageRequest')]
     public function setMessageRequest(Request $request): Response
     {
        
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        return $this->render('users/index.html.twig', [
            'category' => '121',
            'promotions' => ['0', '1'],
            'message'=>''
        ]);
        // ...
     }
     // from a controller method
     #[Route('/user_cache',name:'user_cache')]
    public function listUserCache(TagAwareCacheInterface $myCachePool) : Response
    {
        // ...
        $value1 = $myCachePool->get('item_1', function (ItemInterface $item) {

            $item->tag('foo');

            return new Response(
                '<html><body> Cache set successfuly</body></html>'
            );
        });
        echo '<a href="../../user_index">Back</a>';
        echo "<br>"; 
        return new Response(
            '<html><body> Cache set successfuly</body></html>'
        );
    }
    #[Route('/user_translator',name:'user_translator')]
    public function userMessageTranslator(TranslatorInterface $translator)
    {
        $message = new TranslatableMessage('Symfony is great!');
        
        $translated = $translator->trans('Symfony is great');
        $trans=$translator->trans('symfony.great');
        return new Response(
            '<html><body>Translator.'.$translated.'</body></html>'
        );
        // ...
    }

    #[Route('/user_index',name:'user_index')]
    public function user_index(TranslatorInterface $translator)
    {
        $contents = $this->renderView('users/menu.html.twig', [
            'category' => '121',
            'promotions' => ['0', '1'],
        ]);

        return new Response($contents);
    }

    #[Route('/user_route',name:'user_route')]
    public function user_route(TranslatorInterface $translator)
    {
        $contents = $this->renderView('rotue.html.twig', [
            'category' => '121'
        ]);

        return new Response($contents);
    }

    #[Route('/user_controller',name:'user_controller')]
    public function user_controller(TranslatorInterface $translator)
    {
        $contents = $this->renderView('controller.html.twig', [
            'category' => '121'
        ]);

        return new Response($contents);
    }
    //form

    #[Route('/user_form',name:'user_form')]
    public function userFrom(TranslatorInterface $translator)
    {

        $user= new User();
        $user->setName('vipul_form');
        $user->setEmail('vipul_form@gmail.com');
        $user->setStatus(1);


        $form = $this->createFormBuilder($user)
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('status', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create User'])
            ->getForm();
            
            return $this->render('users/user_form.html.twig', [
                'form' => $form,
            ]);
    }
    //Symfony Form

    //get the all user list
    #[Route('/get_user_list', name: 'get_user_list')]
    public function getUserList(UserRepository $doctrine,int $id=1) :Response
    {   
        //findAll custom funstion  SQL query 
        $users = $doctrine->findAll();
        
        if (!$users) {
            // throw $this->createNotFoundException(
            //     'No User found for id'
            // );
        }
        return $this->render('users/user_list.html.twig', [
            'users' => $users,
        ]);
    }

    // User Registration form for add new user details
    #[Route('/user_add_form',name:'user_add_form')]
    public function userClassFrom(Request $request,ManagerRegistry $doctrine) : Response
    {
        
        $user= new User();
        $user->setName('');
        $user->setEmail('');
        $user->setStatus(1);
        $email_is=false;

        $form = $this->createForm(UserType::class, $user);
        //$form = $this->createForm(UserType::class, [
          //  'action' => $this->generateUrl('user_class_form'),
            //'method' => 'POST']);

        $entityManager = $doctrine->getManager();
        $form->handleRequest($request);
         
            if ($form->isSubmitted() && $form->isValid()) {
            
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $users = $form->getData();
            
             $entityManager->persist($users);

             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();
             // ... perform some action, such as saving the task to the database
 
             return $this->redirectToRoute('get_user_list');
         }
        return $this->render('users/user_form.html.twig', [
            'form' => $form,
        ]);
    }

    //get user details base on user id and update  new  records user details
    #[Route('/get_user_update/{id}', name: 'get_user_update')]
    public function getUserUpdateDetails(ManagerRegistry $doctrine,int $id,Request $request) :Response
    {   
        $entityManager = $doctrine->getManager();
        $users = $entityManager->getRepository(User::class)->find($id);

        if (!$users) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        $users->setName($users->getName());
        $users->setEmail($users->getEmail());
        $users->setStatus($users->getStatus());
        $email_is=false;

        $form = $this->createForm(UserType::class, $users);
        //$form = $this->createForm(UserType::class, [
          //  'action' => $this->generateUrl('user_class_form'),
            //'method' => 'POST']);
        $entityManager = $doctrine->getManager();
        $form->handleRequest($request);
         
            if ($form->isSubmitted() && $form->isValid()) {
            
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $users = $form->getData();

             $entityManager->persist($users);

             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();
             // ... perform some action, such as saving the task to the database
 
             return $this->redirectToRoute('get_user_list');
         }

        return $this->render('users/user_form.html.twig', [
            'form' => $form,
        ]);
        
    }

    //get user details base on user id and Delete records user details
    #[Route('/get_user_delete/{id}', name: 'get_user_delete')]
    public function getUserDelete(ManagerRegistry $doctrine,int $id) :Response
    {   
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        if (!$user) {
            throw $this->createNotFoundException(
                'No User found for id '.$id
            );
        }
        
        return $this->redirectToRoute('get_user_list');
    }


    // custom form create on twig and controller

        #[Route('/user_class_custom_form',name:'user_class_custom_form')]
        public function userClassCustomFrom(TranslatorInterface $translator,ManagerRegistry $doctrine,Request $request)
        {

            $users= new User();
            $users->setName('');
            $users->setEmail('');
            $users->setStatus(1);
                
            $form = $this->createForm(UserType::class, $users);
            $entityManager = $doctrine->getManager();
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
            
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $users = $form->getData();
            
             $entityManager->persist($users);

             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();
             // ... perform some action, such as saving the task to the database
 
             return $this->redirectToRoute('get_user_list');
         }
            return $this->render('users/user_form_custom.html.twig', [
                'form' => $form,
            ]);
        }
        /**
         * @Route("/user_event/new")
         */
        public function new(): Response
        {
            $event = new UsertCreateEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UsertCreateEvent::NAME);
            return new Response('Return your response here.');
        }
        #[Route('/user_event_new',name:'user_event_new')]
        public function user_new(): Response
        {
            $event = new UsertCreateEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UsertCreateEvent::NAME);
            return new Response('Return your response here.');
        }
        #[Route('/user_event_update',name:'user_event_update')]
        public function update(): Response
        {
            $event = new UserUpdateEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UserUpdateEvent::NAME);
            
            return new Response('Return your response here.');
        }
        #[Route('/user_event_delete',name:'user_event_delete')]
        public function delete(): Response
        {
            $event = new UserDeleteEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UserDeleteEvent::NAME);
            
            return new Response('Return your response here.');
        }
        
}
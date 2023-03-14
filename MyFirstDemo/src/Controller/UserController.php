<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UsersWork;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use App\Repository\UsersWorkRepository;
use App\Repository\LocationRepository;
use App\Repository\BranchRepository;
use App\Repository\ContactRepository;
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
use App\Service\SendEmailService;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Type\UserType;
use App\Form\Type\UserTaskType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\UsertCreateEvent;
use App\Event\UserUpdateEvent;
use App\Event\UserDeleteEvent;
use App\Event\UserEventSubscriber;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\ArrayInput;

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

    // get user information form entity user tables data
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

    // add user is used to add fixed records in users table
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

     // add user is used to add fixed records in users table
     #[Route('/add_user_work', name: 'add_user_work')]
     public function createUSerwork(ManagerRegistry $doctrine) :Response
     {
        $entityManager = $doctrine->getManager();
        
         $user= new User();
         $user->setName('vipul_Dev');
         $user->setEmail('vipul@gmail.com');
         $user->setGender('Male');
         $user->setDesciption('text');
         $user->setStatus(1);
         
         //$user = $entityManager->getRepository(User::class)->find(2);
        
         $userwork= new UsersWork();
         $userwork->setTaskname('vipul_Devdfsdf');
         $userwork->setStartdate('03-03-2023');
         $userwork->setEnddate('04-03-2023');
         $userwork->setStatus(1);
         $userwork->setUser($user);
 
 
 
         
         $entityManager->persist($user);
         $entityManager->persist($userwork);
 
         // actually executes the queries (i.e. the INSERT query)
         $entityManager->flush();

         echo '<a href="../../user_index">Back</a>';
         echo "<br>";  
         return new Response(
             'Saved new User with id: '.$user->getId()
             .' and new User Work with id: '.$userwork->getId()
         );
         
     }

      // add user is used to add fixed records in users table
      #[Route('/get_user_work', name: 'get_user_work')]
      public function getUSerwork(ManagerRegistry $doctrine,UserRepository $userRepository,AddressRepository $addressRepository,UsersWorkRepository $usersWorkRepository,LocationRepository $locationRepository) :Response
      {
         $entityManager = $doctrine->getManager();
         
        //get All User
          $user = $doctrine->getRepository(User::class)->find(4);
         
          $userworks=$user->getUsersWorks()->toArray();
          $userCountry=$user->getCountry()->getName();
          $userLocation=$user->getLocations()->toArray();

          
          //get  User BY ID
          $user_id=1;
          $user = $doctrine->getRepository(User::class)->find($user_id);

          $userworks=$user->getUsersWorks()->toArray();
          $userCountry=$user->getCountry()->getName();
          $userLocation=$user->getLocations()->toArray();

          //get query  for Address data form custom query for sql and builder
          $userAddress=$addressRepository->findOneByIdJoinedToAddress($user_id);
           //get query  for Location data form custom query for sql and builder
          $usersLocation=$locationRepository->findByUserId($user_id);
          //get all user and user work base in custom join query
          $getAllUserandWorkOrders=$userRepository->getUSerWorks();


          echo '<a href="../../user_index">Back</a>';
          echo "<br>";  

          return new Response(
              'Saved new User with id: '.$user->getId()
              .' and new User Work with id: '
          );
          
      }
       // add user is used to add fixed records in users table
       #[Route('/get_user_work_list', name: 'get_user_work_list')]
       public function getUerworkList(ManagerRegistry $doctrine,UserRepository $userRepository,AddressRepository $addressRepository,UsersWorkRepository $usersWorkRepository,LocationRepository $locationRepository,ContactRepository $contactRepository,BranchRepository $branchRepository) :Response
       {
          $entityManager = $doctrine->getManager();
         
         //get All User
           $user = $doctrine->getRepository(User::class)->find(5);
          
           $userworks=$user->getUsersWorks()->toArray();
           $userCountry=$user->getCountry()->getName();
           $userLocation=$user->getLocations()->toArray();
           //dd($user,$userworks,$userCountry,$userLocation);
           
           //get  User BY ID
           $user_id=5;
           $user = $doctrine->getRepository(User::class)->find($user_id);
 
           $userworks=$user->getUsersWorks()->toArray();
           $userCountry=$user->getCountry()->getName();
           $userLocation=$user->getLocations()->toArray();
 
           //get query  for Address data form custom query for sql and builder
           //$userAddress=$addressRepository->findAllUserAddress();
           

        //    $userDetails=$userRepository->findOneByIdJoinedToUser(5);
        //    $contryName=$userDetails[0]->getCountry()->getName();
        //    $locationName=$userDetails[0]->getLocations()->toArray()[0]->getLocationName();
        //    $branchName=$userDetails[0]->getBranches()->toArray()[0]->getName();
        //    $workhName=$userDetails[0]->getUsersWorks()->toArray()[0]->getTaskname();
        
           $userAddressBYId=$addressRepository->findOneByIdJoinedToAddress(2);
           $userBranchBYId=$branchRepository->findOneByIdJoinedToBranch(5);
           $leftuserBranchBYId=$branchRepository->findOneByIdleftJoinedToBranch(5);
           $userWorkBYId=$usersWorkRepository->findOneByIdJoinedToWorks(2);
           $usersLocationId=$locationRepository->findAllLocation();
           $usersLocationAll=$usersLocationId[0]->getUser()->toArray()[0]->getName();
           $userAddress=$addressRepository->findAllUserAddress();
           $joinusersLocation=$locationRepository->usersLocationId(3);
           dd($joinusersLocation);
           //dd($userAddressBYId[leftuserBranchBYId]->getuser()->getName());
           //$userAddress=$addressRepository->findOneByIdJoinedToAddress($userId);
            //get query  for Location data form custom query for sql and builder
           
           //$usersLocation=$locationRepository->findAllLocation();

           //get all user and user work base in custom join query
           $userswork=$usersWorkRepository->findByAllUserWork();
           $usersbranch=$branchRepository->findAllUserBranch();
           $userscontact=$contactRepository->findAllContact();
           $users=$userRepository->findAllUser();
           
           dd($usersbranch,$userscontact,$userAddress,$usersLocation, $users,$userswork);
           return $this->render('users/user_work_list.html.twig', [
            'users' => $users,
            ]);
           
       }
        // add user is used to add fixed records in users table
        #[Route('/get_user_work_delete/{id}', name: 'get_user_work_delete')]
        public function getUserworkdelete(int $id,ManagerRegistry $doctrine,UserRepository $userRepository,AddressRepository $addressRepository,UsersWorkRepository $usersWorkRepository,LocationRepository $locationRepository) :Response
        {

           $entityManager = $doctrine->getManager();
           
          //get All User
            $user = $doctrine->getRepository(User::class)->find(7);
            // $entityManager->remove();
            // $entityManager->flush();
            // dd('dd');
            $userworks=$user->getUsersWorks()->toArray();
            $userCountry=$user->getCountry()->getName();
            $userLocation=$user->getLocations()->toArray();
  
            
            //get  User BY ID
            $user_id=1;
            $user = $doctrine->getRepository(User::class)->find($user_id);
  
            $userworks=$user->getUsersWorks()->toArray();
            $userCountry=$user->getCountry()->getName();
            $userLocation=$user->getLocations()->toArray();
  
            //get query  for Address data form custom query for sql and builder
            $userAddress=$addressRepository->findOneByIdJoinedToAddress($user_id);
             //get query  for Location data form custom query for sql and builder
            $usersLocation=$locationRepository->findByUserId($user_id);
            //get all user and user work base in custom join query
            $users=$userRepository->getUSerWorks();
             
            return $this->render('users/user_work_list.html.twig', [
             'users' => $users,
             ]);
            
        }
           // add user is used to add fixed records in users table
      
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
    //using add_user_valid save user  with Validatotion usgin 
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
    // editUser method is used to update fixed id or static redords in user table
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
     // deleteUser method is used to delete fixed id or static redords in user table
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

    // number this function usign route.yaml   routing file
    public function number(LoggerInterface $logger): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
    //string call this routing usging rotue.yaml file
    public function string(): Response
    {
        $string ="vipul";

        return $this->render('users/string.html.twig', [
            'string' => $string,
        ]);
    }
     //search call this routing usging rotue.yaml file
    //https://127.0.0.1:8000/user/en/search.html
    public function search(): Response
    {
        $string ="vipul";

        return $this->render('users/string.html.twig', [
            'string' => $string,
        ]);
    }
    
    //extraParams call this routing usging rotue.yaml file
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
    public function download($path="/path/to/some_file.pdf"): BinaryFileResponse
    {
        // send the file contents and force the browser to download it
//        return $this->file('/path/to/some_file.pdf');
        return $this->file($path);
    }

    //tiwg useing renderView
    #[Route('/user_page',name:'user_page')]
    public function userPage(){

        $contents = $this->renderView('users/index.html.twig', [
            'category' => '121',
            'promotions' => ['0', '1'],
            'message'=>'call'
        ]);

        return new Response($contents);
    }

    //service paramtes 
    #[Route('/user_service_params',name:'user_service_params')]
    public function userPageService(PageService $pageservice): Response
    {
            $adminEmail = $this->getParameter('app.admin_email');
            $envtype = $this->getParameter('app.env.type');
            $dbtype = $this->getParameter('app.db.type');

            $contents = $this->renderView('twig/serivce-paramter.html.twig', [
                'adminEmail' => $adminEmail,
                'envtype' =>  $envtype ,
                'dbtype'=>$dbtype 
            ]);
    
            return new Response($contents);
           
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
                 '<html><body> Generate Message My :'.$message.'</body></html>'
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
     #[Route('/user_twig',name:'user_twig')]
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
     // listUserCache cache example

     #[Route('/user_cache',name:'user_cache')]
    public function listUserCache(TagAwareCacheInterface $myCachePool) : Response
    {
        // ...
        $value1 = $myCachePool->get('item_1', function (ItemInterface $item) {

            $item->tag('vipul');

            return new Response(
                '<html><body> Cache  successfuly</body></html>'
            );
        });
        echo '<a href="../../user_index">Back</a>';
        echo "<br>"; 

        // $this->myCachePool->invalidateTags(['vipul']);
        return new Response(
            '<html><body> Cache  successfuly</body></html>'
        );
    }
    
    //userMessageTranslator user_translator example for string 
    #[Route('/user_translator',name:'user_translator')]
    public function userMessageTranslator(TranslatorInterface $translator,Request $request)
    {

        $request->setLocale('fr');
        $getLocale=$request->getLocale();
        $frtrans=$translator->trans('Symfony is great', locale: $getLocale);
        
        $request->setLocale('en');
        $getLocale=$request->getLocale();
        $entrans=$translator->trans('Symfony is great', locale: $getLocale);
        $message = new TranslatableMessage('Symfony is great!');
        
        $translated = $translator->trans('Symfony is great');
        $trans=$translator->trans('symfony.great');

        $contents = $this->renderView('twig/trans.html.twig', [
            'frtrans' => $frtrans,
            'entrans' => $entrans
        ]);
        return new Response($contents);
        return new Response(
            '<html><body>Translator FR=>'.$translated.' English=>'.$frtrans.'</body></html>'
        );
        // ...
    }

    //user_index used to render the menu list
    #[Route('/user_index',name:'user_index')]
    public function user_index(TranslatorInterface $translator)
    {
        $contents = $this->renderView('users/menu.html.twig', [
            'category' => '121',
            'promotions' => ['0', '1'],
        ]);

        return new Response($contents);
    }

    //user_route used to render the rotues list
    #[Route('/user_route',name:'user_route')]
    public function user_route(TranslatorInterface $translator)
    {
        $contents = $this->renderView('rotue.html.twig', [
            'category' => '121'
        ]);

        return new Response($contents);
    }

    //user_controller used to render the controller  list
    #[Route('/user_controller',name:'user_controller')]
    public function user_controller(TranslatorInterface $translator)
    {
        $contents = $this->renderView('controller.html.twig', [
            'category' => '121'
        ]);

        return new Response($contents);
    }
    //form
    //userFrom function is used to load the user form using controller
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
        ;
        if (!$users) {
            throw $this->createNotFoundException(
                'No User found for id'
            );
        }
        return $this->render('users/user_list.html.twig', [
            'users' => $users,
        ]);
    }

     //get the all user list
     #[Route('/get_user_task_list', name: 'get_user_task_list')]
     public function getUserTaskList(UsersWorkRepository $doctrine,int $id=1) :Response
     {   
         //findAll custom funstion  SQL query 
         
         $usersTask = $doctrine->findByAllUserWork();
        
         if (!$usersTask) {
             throw $this->createNotFoundException(
                 'No User found for id'
             );
         }
         return $this->render('users/user_task_list.html.twig', [
             'usersTask' => $usersTask,
         ]);
     }
 
    // User Registration form for add new user details with type class
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

    // User Registration form for add new user details with type class
    #[Route('/user_task_add_form',name:'user_task_add_form')]
    public function userTaskClassFrom(Request $request,ManagerRegistry $doctrine) : Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find(2);
        $userTask= new UsersWork();
        $userTask->setTaskname('');
        $userTask->getStartdate(date('Y-m-d'));
        $userTask->getEnddate(date('Y-m-d'));
        $userTask->setStatus(1);
        $userTask->setUser($user);
        
        //dd($userTask);
        $form = $this->createForm(UserTaskType::class, $userTask);
        //$form = $this->createForm(UserType::class, [
          //  'action' => $this->generateUrl('user_class_form'),
            //'method' => 'POST']);

       
        $form->handleRequest($request);
         
            if ($form->isSubmitted() && $form->isValid()) {
               
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $userTask = $form->getData();
            
             $entityManager->persist($userTask);
            
                
             // actually executes the queries (i.e. the INSERT query)
             $entityManager->flush();
             // ... perform some action, such as saving the task to the database
            
             return $this->redirectToRoute('get_user_task_list');
         }
        return $this->render('users/user_form.html.twig', [
            'form' => $form,
        ]);
    }   

    // custom form create on twig and controller

        #[Route('/user_class_custom_form',name:'user_class_custom_form')]
        public function userClassCustomFrom(TranslatorInterface $translator,ManagerRegistry $doctrine,Request $request)
        {

            $users= new User();
            $users->setName('');
            $users->setEmail('');
            $users->setStatus(1);
            //dd($request);
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
            //get user details base on user id and Delete records user details
        #[Route('/get_user_task_delete/{id}', name: 'get_user_task_delete')]
        public function getUserTaskDelete(ManagerRegistry $doctrine,int $id) :Response
        {   
            $entityManager = $doctrine->getManager();
            $user = $entityManager->getRepository(UsersWork::class)->find($id);
            $entityManager->remove($user);
            $entityManager->flush();
            if (!$user) {
                throw $this->createNotFoundException(
                    'No User found for id '.$id
                );
            }
            
            return $this->redirectToRoute('get_user_task_list');
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

        //user_new get event when new action call
        #[Route('/user_event_new',name:'user_event_new')]
        public function user_new(): Response
        {
            $event = new UsertCreateEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UsertCreateEvent::NAME);
            return new Response('Return your response here.');
        }
         //update get event when update action call
        #[Route('/user_event_update',name:'user_event_update')]
        public function update(): Response
        {
            $event = new UserUpdateEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UserUpdateEvent::NAME);
            
            return new Response('Return your response here.');
        }
        
          //delete get event when delete action call
        #[Route('/user_event_delete',name:'user_event_delete')]
        public function delete(): Response
        {
            $event = new UserDeleteEvent();
            
            $this->eventDispatcher->addSubscriber(new UserEventSubscriber());
            $this->eventDispatcher->dispatch($event, UserDeleteEvent::NAME);
            
            return new Response('Return your response here.');
        }

        // Http client example and curl call with live url demo 
        #[Route('/test_http_client',name:'test_http_client')]
        public function httpClient(HttpClientInterface $client): array
        {   
            $response = $client->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');

        // getting the response headers waits until they arrive
            $contentType = $response->getHeaders()['content-type'][0];

            // trying to get the response content will block the execution until
            // the full response content is received
            echo "<br>";
            echo '<a href="../../user_index">Back</a>';
            echo "<br>";

            $content = $response->getContent();
            echo "<br>";
            var_dump($content);
            $arr_response=json_decode($content);

            echo $arr_response->homepage;
            dd($arr_response);
            if($arr_response->homepage!=""){

                $this->redirect($arr_response->homepage);
            }
            return new Response('Return your response here.');
            //return $content;
        }
        
         // Http client example and curl call with live url demo 
         #[Route('/scoped_http_seller',name:'scoped_http_seller')]
         public function scopedHttpSeller(HttpClientInterface $sellerApi): array
         {      
            
             $response = $sellerApi->request('GET', 'https://seller.com');
 
         // getting the response headers waits until they arrive
             $contentType = $response->getHeaders()['content-type'][0];
 
             // trying to get the response content will block the execution until
             // the full response content is received
             echo "<br>";
             echo '<a href="../../user_index">Back</a>';
             echo "<br>";
             dd($sellerApi);

             $content = $response->getContent();
             echo "<br>";
             var_dump($content);
             $arr_response=json_decode($content);
 
             echo $arr_response->homepage;
             dd($arr_response);
             if($arr_response->homepage!=""){
 
                 $this->redirect($arr_response->homepage);
             }
             return new Response('Return your response here.');
             //return $content;
         }
         
       
         //Twig Example
        //Render the index page if twig demo
        #[Route('/twig_index',name:'twig_index')]
        public function twigIndex(HttpClientInterface $client): Response
        {   
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->render('twig/index.html.twig', [
                'category' => '121',
                'promotions' => ['0', '1'],
                'message'=>''
            ]);
        }

        //render url and path exmple to render tiwg page to other url  and path  data and record
        #[Route('/twig_render_url_path',name:'twig_render_url_path')]
        public function twigRenderUrlPath(UserRepository $userRepository): Response
        {   
            $users = $userRepository->findAll();
            
            if (!$users) {
                throw $this->createNotFoundException(
                    'No User found for id '
                );
            }
            
            $user_name=$users[0]['name'];
            $this->addFlash(
                'notice',
                'Your changes are  saved! '.$user_name
            );
            
            return $this->render('twig/render-url-path.html.twig', ['users'=>$users]);
        }

        // twigRender render controller exmple to render tiwg page to other controller function data and record
        #[Route('/twig_render_controller',name:'twig_render_controller')]
        public function twigRender(UserRepository $userRepository,Request $request): Response
        {   
            $users = $userRepository->findAll();
            
            if (!$users) {
                throw $this->createNotFoundException(
                    'No User found for id '
                );
            }
            
            $user_name=$users[0]['name'];
            $this->addFlash(
                'notice',
                'Your changes are  saved! '.$user_name
            );
            $location=$request->get('location');
            return $this->render('twig/render-controller.html.twig', ['users'=>$users,'location'=>$location]);
        }

        // get user information base on user id to show inside the twig file page any in page
        #[Route('/get_user_info/{id}',name:'get_user_info')]
        public function userInfo(ManagerRegistry $doctrine,int $id,Request $request) :Response
        {
                
                $entityManager = $doctrine->getManager();
                $user = $entityManager->getRepository(User::class)->find($id);
               
                if (!$user) {
                    throw $this->createNotFoundException(
                        'No user found for id '.$id
                    );
                }
                $response='<br>';
                $response.='<b>User Name </b> '.$user->getName();
                $response.='<br>';
                $response.='<b>User email</b>  '.$user->getEmail();
                $response.='<br>';
                $response.='<b>User Gender</b>  '.$user->getGender();
                $response.='<br>';
                $response.='<b>User Desciption</b>  '.$user->getDesciption();
                $location=1;
                $response.='<b><a href="get_user_update/'.$user->getId().'"> VieMore</a></b>  ';
                return new Response($response);
            
    
        }
        //twigMasterRender ccehchcl render controller exmple to render tiwg page to other controller function data and record
        #[Route('/twig_master_value' ,name:'twig_master_value')]
        public function twigMasterRender(UserRepository $userRepository): Response
        {   
            
            return $this->render('twig/mastervalue.html.twig');
        }

        //twigMasterRender ccehchcl render controller exmple to render tiwg page to other controller function data and record
         #[Route('/sys_email_log' ,name:'sys_email_log')]
         public function syslog(SendEmailService $service): Response
         {   
            $service->storeLog();

            $email="vipul@gmail.com";
            $subject="Test Mail";
            $html='<html>
            <body>
            <p><br>Hey</br>
            You User Account is InActive Now</p>
            <p>Please contact to Admin For Active Account</p>
            <a href="https://127.0.0.1:8000/">ActiveNow</a>
                    </body>
                </html>';
            $service->MailSend($email,$subject,$html);
            
            dd('Log store and email send  done');
        }
        
         //call command using controler function and roting to call cmd
         #[Route('/call_command' ,name:'call_command')]
         public function call_command(KernelInterface $kernel): Response
         {   
            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput([
                'command' => 'user-command',
                // (optional) define the value of command arguments
            ]);

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            $content = $output->fetch();

            // return new Response(""), if you used NullOutput()
            return new Response($content);
        }
        
}
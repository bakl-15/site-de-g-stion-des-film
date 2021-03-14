<?php 
namespace App;
use AltoRouter;
require '../vendor/autoload.php';
use App\Router;

// une constante pour savoir le temps de chargement de la page
define('DEBUG_TIME', microtime(true));

//une constante pour le dossier qui stocke les images
define('UPLOAD_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'uploads' );


// instanciation de la  class woops pour mieux debuguer le code?
$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
//----------------------------------------------------------
     

     // paramétrer la premiere page
   if(isset($_GET['page']) && $_GET['page'] ===1)
   {
      // réecrire l'url dans la premiere page 
    
      $uri = explode('?',$_SERVER['REQUEST_URI'])[0];
      $get = $_GET;
      unset($get['page']);
     $query =  http_build_query($get);
     if(! empty($query))
     {
         $uri = $uri . '?' . $uri;
         header('Location: ' . $uri);
     }
          exit;
   }


//Les router

//definir une constantante pour les chemin d'accés des vues
define('VIEW_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// instancier le retour qui fait objet de la class altorouter
$router = new  Router(VIEW_PATH);
$router->get('/', 'post/index','home')   // page d'accueil et la listes des posts
       ->get('/cinemaSofiane/category/[*:slug]-[i:id]','category/show','category')       
       ->get('/cinemaSofiane/[*:slug]-[i:id]', 'post/show', 'post') // pour la page qui affiche le contenu de post


       //authentification
       ->match('/login', 'auth/login','login') // login 
       ->post('/logout','auth/logout','logout') // logout
       ->match('/logon','auth/new','logon') // log on

       //ADMIN
       //GESTION DES ARTICLES
       ->get('/admin','admin/post/index', 'admin_posts') 
       ->match('/admin/post/[i:id]','admin/post/edit', 'admin_post') 
       ->post('/admin/post/[i:id]/delete','admin/post/delete', 'admin_post_delete') 
       ->match('/admin/post/new','admin/post/new', 'admin_post_new') 

       //Gestion des catégories
       ->get('/admin/categories','admin/category/index', 'admin_categories') 
       ->match('/admin/category/[i:id]','admin/category/edit', 'admin_category') 
       ->post('/admin/category/[i:id]/delete','admin/category/delete', 'admin_category_delete') 
       ->match('/admin/category/new','admin/category/new', 'admin_category_new') 
       

        //users
        ->get('/user/[i:id]','/user/post/index', 'user_posts') 
        ->get('/user/[i:id]/favorie','/user/favorite/index', 'user_favorie') 

        // favories
        ->get('/favorie','/user/favorite/new', 'favorite_new')
        ->get('/favorie/[i:id]','/user/favorite/delete', 'favorite_delete')
        //run 
        ->run();

      

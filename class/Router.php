<?php 

namespace App;
require '../vendor/autoload.php';
use AltoRouter;
use App\security\ForbiddenException;

class Router{
    /**
     * @var string  
     */
    private $view_path;  //proprieté de chemin d'accés de dossier qui contient les vues 
    /**
     * @var altoRouter
     */
    private $router;
   // public $lyout =  'layouts' .DIRECTORY_SEPARATOR .'default';  approche 
    public function __construct(string $view_path)
    {
        $this->view_path = $view_path;
        $this->router = new \AltoRouter();
    }

     public function url(string $name, array $params =[])
     {
       return $this->router->generate($name, $params);
     }

    public function get( string $url, string $view, ?string $name = null ):self
    { 
     $this->router->map('GET',$url , $view, $name );
     return $this;
    }
    public function post( string $url, string $view, ?string $name = null ):self
    { 
     $this->router->map('POST',$url , $view, $name );
     return $this;
    }
    public function match( string $url, string $view, ?string $name = null ):self
    { 
     $this->router->map('POST|GET',$url , $view, $name );
     return $this;
    }

     public function run():self
     {
       $match = $this->router->match();
       $params = $match['params'];
       $view = $match['target'];
       $router = $this;
       $isAdmin = strpos($view, 'admin/') !== false;
       $isUser = strpos($view, 'user/') !== false;
       $isLogon = strpos($view, 'new') !== false;
       $isLogin = strpos($view, 'login') !== false;
       // dd($view);
            if($isAdmin )
               {
                  $layout = 'admin/layouts/default';
               }
             elseif($isUser)
               {
                  $layout = 'user/layouts/default';
               } 
             elseif($isLogin )
               {
                  $layout = 'auth/layouts/default';
               }
              elseif($isLogon)
               {
                  $layout = 'auth/layouts/default';
               }
              else
               {
                   $layout = 'layouts/default';
               }

      
       if($view === null)
       {
         $view = 'e404';
       }
   
       try{
        
        ob_start();
        require $this->view_path . $view .'.php';
        $content = ob_get_clean();

        if($view === 'user_posts')
        {
          require $this->view_path . 'user' . DIRECTORY_SEPARATOR . $layout .'.php';
        }
      
        require $this->view_path .  $layout .'.php';
       }
       catch(ForbiddenException $e){
         header('Location: ' .$this->url('login') . '?forbidden=1');
         exit;
       }
      
       return $this;

       
     }   
}
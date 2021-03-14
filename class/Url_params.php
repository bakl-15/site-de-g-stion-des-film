<?php
namespace App;
use \Exception;
class Url_params{
         // rediriger la url vers la page d'accueil si $_PAGE['page'] !== 0 ou un nombre avec virgule
      public static function getINT(string $name, ?int $default = null): ?int
      {
            if(!isset($_GET[$name]))
            {
                 return $default;   
            }
            if($_GET[$name] === 0)
            {
              
                 return 0;
            }
            
            if(! filter_var($_GET[$name], FILTER_VALIDATE_INT))   // regler le probleme des virgule dans l'url
            {
                 throw New Exception("Le parametre $name  dans l'url, n'est pas un entier");
            } 
                 return (int)$_GET[$name];
      }
     
      public static function getPositiveINT(string $name, ?int $default = null): ?int
      {
         $param = self::getINT($name, $default);
         if($param !== null && $param <=0)
         {
            throw New Exception("Le parametre $name  dans l'url, n'est pas un entier positif");
         }
         return $param;
      }

  

}
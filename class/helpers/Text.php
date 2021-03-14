<?php 
namespace App\helpers;
class Text
{
      
     // fonction pour le resumé de l'article
      public static function excerpt(string $content, int $numberChar = 60): string
      {
          if(mb_strlen($content) <= $numberChar)
          {
              return $content;
          }
          $last_space = mb_strpos($content, ' ', $numberChar);
         return mb_substr($content, 0, $numberChar) . '...';
         
      }
}
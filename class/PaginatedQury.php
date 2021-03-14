<?php 
namespace App;

use \PDO;
use \Exception;
use App\Connection;

// initilisation de constructeur
 class PaginatedQury
        {
            //proprietés
        private $query;
        private $queryCount;
        private $pdo;
        private $per_page;
        private $count;
        
        //constructeur
        public function __construct(
            string $query,
            string $queryCount,
            ?PDO $pdo,
            ?int $per_page = 12
        )
        {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->per_page  = $per_page; 
        }
        
        // Méthode privée
        private function getCurrentPage(): int
        {
           return Url_params::getPositiveINT('page',1);  // recupérer la page currentes
        }

       private function getPages(): int
       {
           if($this->count ===null)
           {
            $this->count = (int) $this->pdo->query($this->queryCount)
                                      ->fetch(PDO::FETCH_NUM)[0];  //recupérer le nombre total de tous les article
           }
         return ceil( $this->count / $this->per_page) ; // le nombre total de page 
       }
        
        //fonction getItems
public function getItems( string $classMapping): array
{
    $curent_page = $this->getCurrentPage() ;
    $pages = $this->getPages();
   
    if($curent_page > $pages)
    {
        throw new Exception('Cette page n\'existe pas ');
    }
     $offset = $this->per_page * ($curent_page - 1);
     
    $query = $this->pdo->query($this->query . " LIMIT {$this->per_page} OFFSET $offset");
    $posts = $query->fetchAll(PDO::FETCH_CLASS, $classMapping);
    return $posts;
}

public function previousLink(string $link): ?string
{
    $currentPage = $this->getCurrentPage();
    if($currentPage <= 1)
    {
        return null;
    }
    if($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
   return  <<<HTML
    <a href="{$link}" class="btn btn-primary"> 	&#8804; Page precedente</a>
HTML;
}
 
public function nextLink(string $link): ?string
{
    $currentPage = $this->getCurrentPage();
    $pages = $this->getPages();
    if($currentPage >= $pages)
    {
        return null;
    }
    $link = "?page=" . ($currentPage +1);
   return  <<<HTML
    <a href="{$link}" class="btn btn-primary ml-auto">  Page suivant &raquo; </a>
HTML;
}


public function pages(string $link, int $current):array
{
     $pages = (int)$this->getPages();
     $arr = [];
     $active = false;
     $attr = null;
    for($i = 1; $i <= $pages; $i++)
    {
       $link = "?page=" . $i;
       if($i === $current)
       {
          $active = true;
       }else{ $active = false;}
       $attr = $active === true ? 'btn btn-primary' : 'btn btn-light' ;
       $arr[] =  ' <a href="' . $link . '" class="' . $attr  . '">'.  $i . '</a>';
    
    }
    return $arr;
}
     

}  

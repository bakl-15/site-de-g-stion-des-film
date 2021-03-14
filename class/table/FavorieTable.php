<?php 
namespace App\table;

use App\model\Favorie;
use App\model\Post;
use \PDO;
use \Exception;
final class FavorieTable extends Table{
    protected $table = 'Favorite';
    protected $class = Post::class;
   
    

    
    public function create(Favorie $favorie):void
    {
      $this->pdo->beginTransaction();
      $query = $this->pdo->prepare("INSERT INTO {$this->table} SET filmID = :filmID, userID = :userID");
  
      $userID = (int)$favorie->getUserID();
      $filmID = (int)$favorie->getFilmID();
     
      $query->bindParam(':filmID', $filmID);
      $query->bindParam(':userID', $userID);
     
      $ok =  $query->execute();
      if($ok === false)
      {
        throw new Exception("Impossible de créer l'enregistrement dans de la table {$this->table}");
      }
    
      $favorie->setID($this->pdo->lastInsertId());
    
    
      $this->pdo->commit();
     
    }
      
       public function getFavoruteByUser( int $userID):array
       {
     
       $sql_favorite = 'SELECT id,filmID, userID FROM favorite  
                                  where  userID = :userID' ;
        $query = $this->pdo->prepare($sql_favorite);
        $query->bindParam(':userID', $userID);
        $smt = $query->execute();
        $favouriesUser = $query->fetchAll(PDO::FETCH_OBJ);
         return $favouriesUser;
       }
     
       public function isFavourite(int $filmID, int $userID ): bool
       {
      
        $favourites = $this->getFavoruteByUser($userID);
         $p =[];

        foreach($favourites as $favourite)
        {
          $p[] = (int) $favourite->filmID;
        }

          if( in_array($filmID, $p))
          {
               
            return true;
          }else{
            return false;
          }
        

       }

       public function getFavoriePosts( int $userID)
       {
     
       $sql_favorite = 'SELECT p.*
                        FROM favorite f
                        JOIN  post p
                        ON p.id = f.filmID
                        where  userID = :userID' ;
        $query = $this->pdo->prepare($sql_favorite);
        $query->bindParam(':userID', $userID);
        $smt = $query->execute();
        $favouriesUser = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
         return $favouriesUser;
       }

       public function deleteByUser(int $filmID)
       {
           $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE filmID = :id");
           $query->bindParam(':id', $filmID);
           $ok =  $query->execute();
           if($ok === false)
           {
             throw new Exception("Impossible de supprimer l'ID $filmID de la table {$this->table}");
           }
       }
       
}

?>
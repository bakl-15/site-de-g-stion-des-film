<?php 
namespace App\table;
use App\PaginatedQury;
use App\Connection;
use App\model\Post;
use App\model\Category;
use App\table\CategoryTable;
use \PDO;
use \Exception;
final class PostTable extends Table{
    protected $table = 'post';
    protected $class = Post::class;
     
      private $per_page = 12;
      private $sql_posts = "SELECT * FROM post ORDER BY dateCreation DESC"; //sql pour afficher les articles
      private  $sql_count ='SELECT COUNT(id) FROM post'; // le nombre total d'article dans la base des données 
      private $sql_for_find = 'SELECT * FROM post where id = :id';

      public function findpaginated()
      {
           $paginatedQuery = new PaginatedQury($this->sql_posts, $this->sql_count, $this->pdo, $this->per_page);
           $posts = $paginatedQuery->getItems(Post::class);
   
          (new CategoryTable($this->pdo))->hydratePosts($posts);
           return [$posts, $paginatedQuery];
      }
        
        public function findPaginatedForCategory(int $category_id)
        {
            $sql_category ="SELECT p.*
            FROM post p
            JOIN post_category pc
            ON pc.post_id = p.id
            where pc.category_id = {$category_id}
            ORDER BY dateCreation
          ";
            $sql_count ='SELECT COUNT(category_id) FROM post_category WHERE category_id = ' . $category_id; // le nombre total d'article dans la base des données 
            $paginatedQuery = new PaginatedQury($sql_category, $sql_count,Connection::getPDO(),12);
            $posts = $paginatedQuery->getItems(Post::class);
            (new CategoryTable($this->pdo))->hydratePosts($posts);
          
           return [$posts, $paginatedQuery];
            
        }
          

     
        public function update(Post $post, $categories):void
        {
          $this->pdo->beginTransaction();
          $query = $this->pdo->prepare("UPDATE {$this->table} SET titre = :titre, slug = :slug, dateCreation = :dateCreation, 
          dateSortir = :dateSortir, dateModification = :dateModification, description = :description, affiche = :affiche, auteur = :auteur WHERE id = :id");
          
          $id = $post->getID();
          $titre = $post->getTitre();
          $slug = $post->getSlug();
          $auteur = $post->getAuteur();
          $description =$post->getDescription();
          $dateCreation = $post->getDateCreation()->format('Y-m-d H:i:s');
          $dateSortir = $post->getDateSortir()->format('Y-m-d H:i:s');
          $dateModification = $post->getDateModification()->format('Y-m-d H:i:s');
          $affiche = $post->getAffiche();
          
          $query->bindParam(':id', $id);
          $query->bindParam(':titre', $titre);
          $query->bindParam(':slug', $slug);
          $query->bindParam(':auteur', $auteur);
          $query->bindParam(':description', $description);
          $query->bindParam(':dateCreation', $dateCreation);
          $query->bindParam(':dateSortir', $dateSortir);
          $query->bindParam(':dateModification', $dateModification);
          $query->bindParam(':affiche', $affiche);
          $ok =  $query->execute();
          if($ok === false)
          {
            throw new Exception("Impossible de mettre à jour l'enregistrement dont l'ID {$post->getID()} de la table {$this->table}");
          }
          $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $post->getID());
          $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ?');
          foreach($categories as $category)
          {
             $query->execute([$post->getID(), $category]);
          }
          $this->pdo->commit();
        }

        public function create(Post $post, array $categories):void
        {
          $this->pdo->beginTransaction();
          $query = $this->pdo->prepare("INSERT INTO {$this->table} SET titre = :titre, auteur = :auteur, slug = :slug, dateCreation = :dateCreation, dateSortir = :dateSortir, dateModification = :dateModification, description = :description, affiche = :affiche");
         // $id = $post->getID();
          $titre = $post->getTitre();
          $slug = $post->getSlug();
          $auteur = $post->getAuteur();
          $description =$post->getDescription();
          $dateCreation = $post->getDateCreation()->format('Y-m-d H:i:s');
          $dateSortir = $post->getDateSortir()->format('Y-m-d H:i:s');
          $dateModification = $post->getDateModification()->format('Y-m-d H:i:s');
          $affiche = $post->getAffiche();
          //$query->bindParam(':id', $id);
          $query->bindParam(':titre', $titre);
          $query->bindParam(':auteur', $auteur);
          $query->bindParam(':slug', $slug);
          $query->bindParam(':description', $description);
          $query->bindParam(':dateCreation', $dateCreation);
          $query->bindParam(':dateSortir', $dateSortir);
          $query->bindParam(':dateModification', $dateModification);
          $query->bindParam(':affiche', $affiche);
          $ok =  $query->execute();
          if($ok === false)
          {
            throw new Exception("Impossible de créer l'enregistrement dans de la table {$this->table}");
          }
        
          $post->setID($this->pdo->lastInsertId());
        
          $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $post->getID());
          $queryb = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ?');
          foreach($categories as $k =>$category)
          {
             $queryb->execute([$post->getID(),(int)$category]);
          }
          $this->pdo->commit();
         
        }
        
}
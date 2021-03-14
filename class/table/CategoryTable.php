<?php
namespace App\table;
use \PDO;
use App\model\Category;
use App\table\NotFoundException;
use \Exception;
final class CategoryTable extends Table{

    protected $table = 'category';
    protected $class = Category::class;

    private $sql_category = 'SELECT * FROM category where id = :id';
    private $sql_category_two ='SELECT c.*, pc.post_id FROM post_category pc 
                              JOIN category c ON c.id = pc.category_id
                              WHERE pc.post_id IN ( ';
   public function find(int $id) : ?Category
   {
    $query = $this->pdo->prepare($this->sql_category);
    $query->bindParam(':id', $id,  PDO::PARAM_INT);
    $query->setFetchMode(PDO::FETCH_CLASS, Category::class);
    $query->execute();
    $result = $query->fetch();
    if($result === false)
    {
        throw new  NotFoundException('catégory', $id);
    }
    return $result;
   }
   
   //Associer les catégorie  pour les posts
   public  function hydratePosts(array $posts):void
   {
    $postByID = [];
    foreach($posts as $post)
    {
        $post->setCategories([]);
        $postByID[$post->getID()] = $post;
    }
    
    $str_ids = implode(',', array_keys($postByID));
    
    $categories = $this->pdo
                             ->query($this->sql_category_two  . $str_ids . ')')
                             ->fetchAll(PDO::FETCH_CLASS, Category::class);
          
    
    foreach($categories as $category)
    {
      $postByID[$category->getPost_id()]->addCategory($category) ;
    }
   }
   public function update(Category $category):void
   {
     $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug WHERE id = :id");
     $id = $category->getID();
     $name = $category->getName();
     $slug = $category->getSlug();
     $query->bindParam(':id', $id);
     $query->bindParam(':name', $name);
     $query->bindParam(':slug', $slug);
     $ok =  $query->execute();
     if($ok === false)
     {
       throw new Exception("Impossible de mettre à jour l'enregistrement dont l'ID {$category->getID()} de la table {$this->table}");
     }
   }
   public function create(Category $category):void
   {
     $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name = :name, slug = :slug ");
     //$id = $category->getID();
     $name = $category->getName();
     $slug = $category->getSlug();
   
     //$query->bindParam(':name', $id);
     $query->bindParam(':name', $name);
     $query->bindParam(':slug', $slug);
  
     $ok =  $query->execute();
     if($ok === false)
     {
       throw new Exception("Impossible de créer l'enregistrement dans de la table {$this->table}");
     }
   
     $category->setID($this->pdo->lastInsertId());
    
   }

   public function list(): array
   {
         $categories = $this->all();
         $results=[];
         foreach($categories as $category)
         {
              $results[$category->getID()] = $category->getName();
         }
         return $results;
   }

 
}
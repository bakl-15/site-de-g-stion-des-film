<?php
namespace App\table;
use \PDO;
use \Exception;
abstract class Table{
    protected $pdo;
    protected $table = null;
    protected $class = null;
    public function __construct( PDO $pdo)
    {
        if($this->table ===null)
        {
            throw new Exception("La class getClass($this) n'a pas  de proprieté table");
        }
       $this->pdo = $pdo;
    }

    public function find(int $id) 
      {
       $query = $this->pdo->prepare("SELECT * FROM {$this->table} where id = :id");
       $query->bindParam(':id', $id,  PDO::PARAM_INT);
       $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
       $query->execute();
       $result = $query->fetch();
       if($result === false)
       {
           throw new  NotFoundException($this->table, $id);
       }
       return $result;
      }
      
      /**
         * vérifier si une valeur existe en bas de données
         * @param string field champs à rechercher
         * @param string $value la valeur associé au champs
         */
        public function exists(string $field, $valu,  ?int $exc = null): bool
        {
          $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = :v";

           if($exc !== null)
           {
             $sql .= ' AND id != :e';
           }
          
          $query = $this->pdo->prepare($sql);
          if($exc !== null){
            $query->bindParam(':e', $exc);
          }
          $query->bindParam(':v', $valu);
         
          $query->execute();
          $result = $query->fetch(PDO::FETCH_NUM);
          return (int) $result[0] > 0; //;
        }

        public function all(){
          $sql = "SELECT * FROM {$this->table}";
         return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
        }

        public function delete($id)
        {
          $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
          $query->bindParam(':id', $id);
          $ok =  $query->execute();
          if($ok === false)
          {
            throw new Exception("Impossible de supprimer l'ID $id de la table {$this->table}");
          }
        }
      

}       

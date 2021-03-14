<?php 
namespace App\table;
use App\Connection;
use App\model\User;
use \PDO;
use \Exception;

use App\table\NotFoundException;
final class UserTable extends Table{
    protected $table = 'user';
    protected $class = User::class;

     public function findByUsername(string $username) {
      $query = $this->pdo->prepare("SELECT * FROM {$this->table} where username = :username");
      $query->bindParam(':username', $username,  PDO::PARAM_STR);
      $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
      $query->execute();
      $result = $query->fetch();
      if($result === false)
      {
          throw new  NotFoundException($this->table, $username);
      }
      return $result;
     }   

     public function addUser(User $user):void
     {
       $this->pdo->beginTransaction();
       $query = $this->pdo->prepare("INSERT INTO {$this->table} SET username = :username, password = :password, email = :email,
       genre = :genre, role = :role, avatar = :avatar, dateNaissance = :dateNaissance, cgu = :cgu, dateCreation = :dateCreation,
       dateModification = :dateModification");
      // $id = $post->getID();
       $username = e($user->getUsername());
       $password =  password_hash(e($user->getPassword()),  PASSWORD_BCRYPT);
       $email = e($user->getEmail());
       $genre = $user->getGenre();
       $role = 'ROLE_USER';
       $avatar = $user->getAvatar();
       $dateNaissance = e($user->getDateNaissance()->format('Y-m-d H:i:s'));
       $dateCreation = e($user->getDateCreation()->format('Y-m-d H:i:s'));
       $dateModification = e($user->getDateModification()->format('Y-m-d H:i:s'));
       $cgu = e($user->getCgu()[0]);
       //$query->bindParam(':id', $id);
       $query->bindParam(':username', $username);
       $query->bindParam(':password', $password);
       $query->bindParam(':email', $email);
       $query->bindParam(':genre', $genre);
       $query->bindParam(':role', $role); 
       $query->bindParam(':avatar', $avatar);
       $query->bindParam(':dateNaissance', $dateNaissance);
       $query->bindParam(':dateCreation', $dateCreation);
       $query->bindParam(':dateModification', $dateModification);
       $query->bindParam(':cgu', $cgu);
       
       $ok =  $query->execute();
       if($ok === false)
       {
         throw new Exception("Impossible de créer l'enregistrement dans de la table {$this->table}");
       }
     
       $user->setID($this->pdo->lastInsertId());
     
       $this->pdo->commit();
      
     }
}

   
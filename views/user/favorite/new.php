<?php   ///// ,partie logique

use App\Connection;
use App\table\FavorieTable;
use App\model\Favorie;
use App\ObjectHelper;
if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}
$title ='Ajouter';

$favorie = new Favorie;


//Partie traitement des données 

if(!empty($_GET))
{
      $pdo = Connection::getPDO();
      $table = new FavorieTable($pdo);
      $favorie->setFilmID($_GET['favorie']);
      $favorie->setUserID($_SESSION['auth_user']);
      $table->create($favorie);
      header('Location: ' . $router->url('user_posts',['id' => $_SESSION['auth_user']]) . '?created= ' . $_GET['favorie']);
      exit();
}


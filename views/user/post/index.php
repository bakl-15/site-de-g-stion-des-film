<?php
use App\Connection;
use App\table\PostTable;
use App\table\FavorieTable;
use App\auth\Auth;
use App\model\Favorie;

Auth::check_user();
$title =  'Administration';
$pdo = Connection::getPDO();
$link = $router->url('user_posts',['id' => substr($_SERVER['REQUEST_URI'],6) ] ) ;
[$posts, $pagination] = (new PostTable($pdo))->findpaginated();
//dd($_SERVER);
$favorie = new Favorie;
$post_favorites = null;
$table = new FavorieTable($pdo);

// //--------------------
//  $p = [];
// $favourites = $table->getFavoruteByUser($_SESSION['auth_user']);
// foreach( $favourites as $favourite){
//     $p[] = $favourite->filmID;
// }
//   dd($p)
// //-----



?>
  <?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement a bien été supprimé !
    </div>
  <?php endif ?>
 
<table class="table table-striped mt-4">
    <thead>
             <th>Affiche</th>
             <th>#</th>
             <th>Titre</th>
             <th>Auteur</th>
             <th>Resumé</th>
             <th>Date de création</th>
             <th>Action</th>
    </thead>
    <tbody>
        <?php foreach($posts as $post): ?>
        <tr>
            <td>
                 <img src="/uploads/post/<?= $post->getAffiche()?>" alt="" srcset=""  style="width:100px" class="card-img-top"> 
            </td>
            <td>
                <?= $post->getID()?>
            </td>
            <td>
                <?=e($post->getTitre())?>
            </td>
            <td>
                <?=e($post->getAuteur())?>
            </td>
            <td>
                <?=e($post->getSlug())?>
            </td>
            <td>
                <?=e($post->getDateCreation()->format('Y/m/d'))?>
            </td>
            <td>
             
                <form action="<?= $router->url('favorite_new')?>" method="GET" >
                  
                   <button type="submit" name="favorie" class="btn btn-danger" value="<?= $post->getID()?>" 
                    <?= $table->isFavourite($post->getID(), $_SESSION['auth_user']) === true ? 'hidden': ''?>> 
                        
                          Ajouter aux favories
                   </button>

                </form>  
                    
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="d-flex justify-content-between my-4">
      <?=$pagination->previousLink($link)?>
      <?=$pagination->nextLink($link)?>
 </div>
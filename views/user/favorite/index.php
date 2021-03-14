<?php
use App\Connection;
use App\table\FavorieTable;
use App\auth\Auth;
use     App\model\Favorie;
Auth::check_user();
$title =  'Géstion des favories ';
$pdo = Connection::getPDO();
$favorie = new Favorie;
$post_favorites = null;
$table = new FavorieTable($pdo);
$posts = $table-> getFavoriePosts($_SESSION['auth_user']);
?>
 


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
             
                <form action="<?= $router->url('favorite_delete',['id' => $post->getID()])?>" method="GET" >
                  
                   <button type="submit" name="favorie-delete" class="btn btn-danger" value="<?= $post->getID()?>" > 
                          Supprimer
                   </button>

                </form>  
                    
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
    </tbody>
</table>
<!-- <div class="d-flex justify-content-between my-4">
   
 </div> -->
<?php
use App\Connection;
use App\table\PostTable;
use App\auth\Auth;
Auth::check_admin();
$title =  'Administration';
$pdo = Connection::getPDO();
$link = $router->url('admin_posts');
[$user, $pagination] = (new PostTable($pdo))->findpaginated();

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
             <th>
                 <a href="<?= $router->url('admin_post_new');?>" class="btn btn-primary"> Nouveau</a>
             </th>
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
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()])?>">
                    <?=e($post->getTitre())?>
                </a>
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
                <a href="<?= $router->url('admin_post', ['id' => $post->getID()])?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()])?>" 
                   onsubmit="return confirm('Voulez vous vraiment effectuer cette action')" method="post" style="display:inline">
                   <button type="submit" class="btn btn-danger">Supprimer</button>
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
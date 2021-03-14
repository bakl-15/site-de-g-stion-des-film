<?php
use App\Connection;
use App\table\CategoryTable;
use App\auth\Auth;
Auth::check_admin();
$title =  'Géstion des catégories ';
$pdo = Connection::getPDO();
$link = $router->url('admin_categories');
$items = (new CategoryTable($pdo))->all();

?>
  <?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement a bien été supprimé !
    </div>

  <?php endif ?>
<table class="table table-striped mt-4">
    <thead>
             <th>#</th>
             <th>Titre</th>
             <th>URL</th>
             <th>
                 <a href="<?= $router->url('admin_category_new');?>" class="btn btn-primary"> Nouveau</a>
             </th>
    </thead>
    <tbody>
        <?php foreach($items as $item): ?>
        <tr>
            <td>
                <?= $item->getID()?>
            </td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()])?>">
                    <?=e($item->getName())?>
                </a>
            </td>
            <td>
                <?= $item->getSlug()?>
            </td>
            <td>
                <a href="<?= $router->url('admin_category', ['id' => $item->getID()])?>" class="btn btn-primary">
                    Editer
                </a>
                <form action="<?= $router->url('admin_category_delete', ['id' => $item->getID()])?>" 
                   onsubmit="return confirm('Voulez vous vraiment effectuer cette action')" method="post" style="display:inline">
                   <button type="submit" class="btn btn-danger">Supprimer</button>
                 </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<!-- <div class="d-flex justify-content-between my-4">
   
 </div> -->
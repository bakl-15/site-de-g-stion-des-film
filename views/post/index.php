<?php //require VIEW_PATH . '/layouts/header.php'; ?>
<?php
 use App\Connection;
 use App\table\PostTable;
// variable titre
 $title = 'mon blog'; 
 $pdo = Connection::getPDO();  //connexion à base de données
 $table = new PostTable($pdo);  //instance de postTable, classe pour interagir avec la base de données
 [$posts, $pagination] = $table->findpaginated();

//variable lien
$link = $router->url('home');

?>


 <div class="container bg-light">
 <img src="http://www.geemagic.com/wp-content/uploads/2016/07/Banner-Site.png" height="300px" width="100%">
 <nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-4">
       <ul class="navbar-nav">
            <li class="nav-item">
                 <a href="<?= $router->url('admin_posts')?>" class="nav-link">Série</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Documentaire</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Action</a>
           </li>
           <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Horreur</a>
           </li>
           <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Drama</a>
           </li>
           
        </ul>
 </nav>
   <h1>Nouveau films</h1>
   <div class="row mt-4">
       <?php foreach($posts as $post): ?>
       <div class="col-md-3">
           <?php require 'card.php';?>    
        </div>
   
       <?php endforeach  ?>
   </div>
 </div>
 <div class="d-flex justify-content-between my-4">
      <?=$pagination->previousLink($link)?>

      <?php foreach($pagination->pages($link, isset($_GET['page'])?$_GET['page'] :1 ) as  $p): ?> 
      <?= $p?>
      <?php endforeach ?>
      <?=$pagination->nextLink($link)?>
  
 </div>



<?php //require VIEW_PATH . '/layouts/footer.php'; ?>
<?php 
use App\Connection;
use App\model\Category;
use App\model\Post;
use App\table\CategoryTable;
use App\table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);
//dd($post);
$title = $post->getTitre();

if($post->getSlug() !== $slug)
{
    $url = $router->url('post', ['slug'=> $post->getSlug(), 'id' => $id]) ;
    http_response_code(301);
    header('Location: ' . $url );
}

?>

          <h1> Film : <?= $post->getTitre(); ?></h1>
         <p class="text-muted">
             Date: 
             <?= $post->getDateCreation()->format('d F Y H:i')?>
         </p>
         <p class="text-muted">
             Auteur: 
             <?= $post->getAuteur()?>
         </p>
         <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                Affiche :
                <img src="<?=$post->getAfficheUrl()?>" alt="" width="200px" height="500px" class="card-img-top">
                </div>
                <div class="col-md-3"></div>
            </div>
         </div>
         
         <?php foreach($post->getCategories() as $k => $category):?>
          <?php if($k > 0):?>
            , 
          <?php endif?>
            <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])?>"> <?= e($category->getName());?></a>
         <?php endforeach ?>
         <p>
            Déscription: <?= $post->getFormattedContent(); ?>
        </p>
        <p>
            Duration :
        </p>
        
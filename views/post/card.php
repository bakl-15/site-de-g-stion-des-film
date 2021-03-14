<?php

//recuperer les categories de chaque article 
$categories = [];
foreach($post->getCategories()  as $k => $category)
{
   $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
   $categories[] = <<<HTML
<a href="{$url}"> {$category->getName()}</a>
HTML;
}
//dd($categories);
?>


<!-- génerer les cardes en html -->
<div class="card">
    <?php if($post->getAffiche()):?>
      <img src="<?=$post->getAfficheUrl()?>" alt="" width="200px" height="200px" class="card-img-top">
    <?php endif ?>
    <div class="card-body">
         <h5 class="card-title"> <?= $post->getTitre(); ?></h5>
         <p class="text-muted">
             <?= $post->getDateCreation()->format('d F Y H:i')?>
                <ul class="list-group list-group-flush" style="border:1px">
                     <?php foreach($categories as $category)  : ?>
                           <li class="list-group-item">  <?= $category?> </li>  
                     <?php endforeach ?>
                </ul>
            
         </p>
        
               <?= $post->getExcerpt(); ?> 
        
         <p>
             <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug() ])?>" class="btn btn-primary"> Voir plus</a>
            
         </p>
    </div>
</div>
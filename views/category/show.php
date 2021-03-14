<?php //require VIEW_PATH . '/layouts/header.php'; ?>
<?php 
use App\Connection;
use App\model\Category;
use App\model\Post;
use App\Url_params;
use App\PaginatedQury;
use App\table\CategoryTable;
use App\table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);

if($category->getSlug() !== $slug)
{
    $url = $router->url('category', ['slug'=> $category->getSlug(), 'id' => $id]) ;
    http_response_code(301);
    header('Location: ' . $url );
}

//récupérer les catégories et les  rédirection=

$title = 'categorie: ' . e($category->getName());

[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($category->getID());
$link = $router->url('category',['id'=> $category->getID(), 'slug' => $category->getSlug()]); //important
?>
<h1>Ma catégorie :  <?= e($category->getName())?></h1>

<h1>mes articles</h1>
  <div class="container">
   <div class="row">
       <?php foreach($posts as $post): ?>
       <div class="col-md-3">
           <?php require dirname(__DIR__) .'/post/card.php';?>    
        </div>
       <?php endforeach ?>
   </div>    
 </div>
 <div class="d-flex justify-content-between my-4">
     <?=$paginatedQuery->previousLink($link); ?>
     <?=$paginatedQuery->nextLink($link); ?>
 </div>

<?php // require VIEW_PATH . '/layouts/footer.php'; ?>
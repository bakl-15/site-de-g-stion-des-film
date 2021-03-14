<?php   ///// ,partie logique

use App\Connection;
use App\table\PostTable;
use App\model\Post;
new Valitron\Validator;
use App\html\Form;
use App\validators\PostValidator;
use App\ObjectHelper;
use App\table\CategoryTable;
use App\auth\Auth;
use App\file\PostAttachment;
Auth::check_admin();
$title ='Ajouter';
$success = false;
$errors = [];
$pdo = Connection::getPDO();
$post = new Post;
$post->setDateCreation(date('Y-m-d H:i:s'));
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
//dd($_POST['categories_ids'][0]);
//$categoryTable->hydratePosts([$post]);
//Partie traitement des données 
if(!empty($_POST))
{
      $postTable = new PostTable($pdo);
      $data = array_merge($_POST, $_FILES);
    // librerie de validation
      Valitron\Validator::lang('fr');
       $v = new postValidator($data, $postTable, $post->getID(), $categories );
       ObjectHelper::hydrate($post,$data,['titre', 'description','auteur', 'slug', 'dateCreation','dateSortir','dateModification', 'affiche']);
     
    if($v->validate()){
        //dd($_POST['categories_ids']);
    
        PostAttachment::upload($post);
        $postTable->create($post, $_POST['categories_ids']);
        $success = true;
   
        header('Location: ' . $router->url('admin_post',['id' => $post->getID()]) . '?created=1');
        exit();
    }else{
        $success  = false;
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if($success):?>
    <div class="alert alert-success">
        Les informations ont bien été enregistré !
    </div>
<?php endif ?>

<?php if(!empty($errors)):?>
    <div class="alert alert-danger">
        L'article n'a pas pu étre enregistré, corrigez vos érreurs
    </div>
<?php endif ?>

<h1>Creer un article </h1>

<div class="container">
    <div class="row">       
        <div class="col-md-12">
          <?php require('__form.php'); ?>
        </div>
    </div>
</div>
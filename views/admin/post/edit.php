<?php   ///// ,partie logique

use App\Connection;
use App\table\PostTable;
new Valitron\Validator;
use App\html\Form;
use App\validators\PostValidator;
use App\ObjectHelper;
use App\auth\Auth;
use App\table\CategoryTable;
use App\file\PostAttachment;

Auth::check_admin();
$title ='Editer';
$success = false;
$errors = [];
$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$categoryTable->hydratePosts([$post]);



if(!empty($_POST))
{
    // librerie de validation
      $data = array_merge($_POST,$_FILES);
    //dd($_FILES);
      Valitron\Validator::lang('fr');
       $v = new postValidator(array_merge($_POST,$_FILES), $postTable, $post->getID(), $categories);
       ObjectHelper::hydrate($post,$data,['titre', 'description','auteur', 'slug', 'dateCreation','dateSortir','dateModification', 'affiche' ]);

      if($v->validate()){
    
        PostAttachment::upload($post);
        $postTable->update($post,$_POST['categories_ids']);
        
        $categoryTable->hydratePosts([$post]);
        $success = true;
    }else{
        $success  = false;
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if($success):?>
    <div class="alert alert-success">
        Les informations ont bien été modifié
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])):?>
    <div class="alert alert-success">
        L'article a été bien creé' !
    </div>
<?php endif ?>

<?php if(!empty($errors)):?>
    <div class="alert alert-danger">
        L'article n'a pas pu étre modifié, corrigez vos érreurs
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($params['id'])?></h1>

<div class="container">
    <div class="row">       
        <div class="col-md-12">
        <?php require('__form.php'); ?>
        </div>
    </div>
</div>
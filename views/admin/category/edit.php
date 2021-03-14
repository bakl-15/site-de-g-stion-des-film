<?php   ///// ,partie logique

use App\Connection;
use App\table\CategoryTable;
new Valitron\Validator;
use App\html\Form;
use App\validators\CategoryValidator;
use App\ObjectHelper;
use App\auth\Auth;
Auth::check_admin();
$title ='Editer';
$success = false;
$errors = [];
$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($params['id']);
$fields = ['name',  'slug'];

if(!empty($_POST))
{
    // librerie de validation
      Valitron\Validator::lang('fr');
       $v = new CategoryValidator($_POST, $categoryTable, $category->getID());
       ObjectHelper::hydrate($category,$_POST,$fields);

      if($v->validate()){
        $categoryTable->update($category);
        $success = true;
    }else{
        $success  = false;
        $errors = $v->errors();
    }
}

$form = new Form($category, $errors);
?>

<?php if($success):?>
    <div class="alert alert-success">
        Les informations ont bien été modifié
    </div>
<?php endif ?>

<?php if(isset($_GET['created'])):?>
    <div class="alert alert-success">
        La catégorie a été bien creé' !
    </div>
<?php endif ?>

<?php if(!empty($errors)):?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu étre modifié, merci de corriger vos érreurs !
    </div>
<?php endif ?>

<h1>Editer la catégorie <?= e($category->getName())?></h1>

<div class="container">
    <div class="row">       
        <div class="col-md-12">
        <?php require('__form.php'); ?>
        </div>
    </div>
</div>
<?php   ///// ,partie logique

use App\Connection;
use App\table\CategoryTable;
use App\model\Category;
new Valitron\Validator;
use App\html\Form;
use App\validators\CategoryValidator;
use App\ObjectHelper;
$title ='Ajouter';
$success = false;
$errors = [];
$category = new Category;
use App\auth\Auth;
Auth::check_admin();

//Partie traitement des données 

if(!empty($_POST))
{
      $pdo = Connection::getPDO();
      $table = new CategoryTable($pdo);
   
    // librerie de validation
      Valitron\Validator::lang('fr');
       $v = new CategoryValidator($_POST, $table);
       ObjectHelper::hydrate($category, $_POST,['name', 'slug']);
 
    if($v->validate()){

        $table->create($category);
        $success = true;
   
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    }else{
        $success  = false;
        $errors = $v->errors();
    }
}

$form = new Form($category, $errors);
?>

<?php if($success):?>
    <div class="alert alert-success">
        Les informations ont bien été enregistré !
    </div>
<?php endif ?>

<?php if(!empty($errors)):?>
    <div class="alert alert-danger">
        La catégorie n'a pas pu étre enregistré, merci de corriger vos érreurs
    </div>
<?php endif ?>

<h1>Creer une catégorie </h1>

<div class="container">
    <div class="row">       
        <div class="col-md-12">
          <?php require('__form.php'); ?>
        </div>
    </div>
</div>
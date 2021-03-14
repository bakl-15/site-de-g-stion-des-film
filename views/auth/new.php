<?php   

use App\Connection;
use App\table\UserTable;
use App\model\User;
new Valitron\Validator;
use App\html\Form;
use App\validators\UserValidator;
use App\ObjectHelper;

$title ='Ajouter';
$success = false;
$errors = [];
$pdo = Connection::getPDO();
$user = new User;
$user->setDateCreation(date('Y-m-d H:i:s'));
$user->setDateNaissance(date('Y-m-d H:i:s'));

if(!empty($_POST))
{
      $userTable = new UserTable($pdo);
      $data = $_POST;
     
    // librerie de validation
      Valitron\Validator::lang('fr');

       $v = new UserValidator($data, $userTable, $user->getID());
       ObjectHelper::hydrate($user,$data,['username' ,'confirm', 'password', 'email',
       'genre','dateCreation','dateModification' ,'dateNaissance', 'cgu']);
       
     
    if($v->validate()){
        $userTable->addUser($user);
        $success = true;
   
        header('Location: ' . $router->url('login') . '?created=true');
        exit();
    }else{
        $success  = false;
        $errors = $v->errors();
    }
}

$form = new Form($user, $errors);
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

<h1> S'inscrire </h1>
<a href="<?= $router->url('login')?>" >Se connecter</a>
<div class="container bg-light mg-4" >
    <div class="row">
        <div class="col-md-3">
          
        </div>       
        <div class="col-md-6">
            <?php require('__form.php'); ?>
        </div>
        <div class="col-md-3">
          
        </div> 
    </div>
</div>
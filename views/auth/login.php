<?php

use App\Connection;
use App\model\User;
 use App\html\Form;
use App\table\NotFoundException;
use App\table\UserTable;

$user = new User;

 $errors = [];
 if(!empty($_POST))
 {
     $user->setUsername($_POST['username']);
     $errors['password'] = ['Identifiant ou mot de passe incorrect'];
     if(!empty($_POST['username'] && !empty($_POST['password'] ) ))
     {
        $pdo = Connection::getPDO();
        $table = new UserTable($pdo);
        try{
           $u = $table->findByUsername(e($_POST['username']));
           $u->getPassword();
           $_POST['password'];
        
      
       
          if( password_verify( $_POST['password'], $u->getPassword()))
             {
                 session_start();
                 if($u->getRole() === 'ROLE_ADMIN'){
                    $_SESSION['username'] =  $u->getUsername();
                  $_SESSION['auth_admin'] = $u->getID();
                  $_SESSION['role'] = $u->getRole();
                  header('Location: ' . $router->url('admin_posts'));
                  exit;
                 }
                 if($u->getRole() === 'ROLE_USER'){
                  $_SESSION['username'] =  $u->getUsername();
                  $_SESSION['auth_user'] = $u->getID();
                  $_SESSION['role'] = $u->getRole();
                  header('Location: ' . $router->url('user_posts', ['id' => $u->getId()]));
                  exit;
                 }
              
              
             }
        } catch (NotFoundException $e)
        {
           ;
        }
     }

   
    

 }
 $form = new Form($user, $errors);
?>
<h1>Se connecter</h1>
<?php if(isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
   vous ne pouvez pas accéder à cette page 
</div>
<?php endif ?>
<div class="row bg-light">
   <div class="col-md-3">
   </div>
   <div class="col-md-6">
       <form action="<?= $router->url('login')?>" method="POST">
            <?= $form->input('username', 'Nom d\'utilisateur'); ?>
            <?= $form->input('password', 'Mot de passe'); ?>
            <button type="submit" class="btn btn-primary"> Se connecter</button>
       
         </form>
         <a href="<?= $router->url('logon')?>" >S'inscrire</a>
   </div>
   <div class="col-md-3">
   </div>
</div>





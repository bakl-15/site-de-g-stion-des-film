<?php
$username = null;
 if(session_status() === PHP_SESSION_NONE)
  {
      session_start();
      if(isset( $username)){
        $username = $_SESSION['username'];
      }
     
  }
 //dd($_SESSION['username']);
?>


<!DOCTYPE html >
<html lang="fr" class="h-100">
<head>
 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <link rel="stylesheet" href="../../../assets/css/style.css">
    <title><?= isset($title)? e($title) :'Mon site';?></title>
    
</head>
<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand btn btn-primary" href="#">CinémaGold </a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                 <a href="<?= $router->url('home')?>" class="nav-link" >accueil</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('user_posts',['id' => $_SESSION['auth_user']])?>" class="nav-link" >Dashboard</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('user_favorie',['id' => $_SESSION['auth_user']])?>" class="nav-link" >Mes favories</a>
            </li>
            <li class="nav-item">
                 <form action="<?= $router->url('logout')?>" method="post" style="display:inline; padding-left:50vw">
                     <button type="submit" class="btn btn-secondary mt-4"> Se déconnecter</button>
                 </form>
            </li>
            <li class="nav-item btn btn-dark ml-4">
                  <?= $_SESSION['username']?>
            </li>
      </ul>
    
    </div>
  </div>
</nav>
   <div class="container">
   <?= $content?>
   </div>
   <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
              page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME))?>  ms
        </div>
   </footer>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
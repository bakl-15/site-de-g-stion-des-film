<?php 
  use App\auth\Auth;
  if(session_status() === PHP_SESSION_NONE)
  {
      session_start();
  }
  $ok ;
  $connected = null;
  $url = null;
  if(isset($_SESSION['username']))
  {
        $connected = $_SESSION['username'];
        if(isset( $_SESSION['role']))
        {
          $url = $_SESSION['role']  === 'ROLE_ADMIN'? $url = $router->url('admin_posts'): $url = $router->url('user_posts', ['id' =>$_SESSION['auth_user'] ]) ; 
        }
        $ok = true;
  }else{
     $ok = false;
     $connected = 'Se connecter' ;
     $url = $router->url('login');
  }
    //dd($ok);

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
   <nav class="navbar navbar-expand-lg navbar-dark bg-light">
        <a href="" class="navbar-brand bg-primary">CinémaGold</a>
        <form class="d-flex ml-4">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <li class="nav-item">
          <a class="nav-link   ml-4"  href="<?=$url?>" style="padding-left:750px"> <?= $connected?></a>
        </li>
        <li class="nav-item" >
          <a class="nav-link ml-4 " href="<?=$router->url('logon')?>" <?= $ok === true ? 'hidden' : ''?>>Créer un compte</a>
        </li>
        
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
<!DOCTYPE html >
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title><?= isset($title)? e($title) :'Mon site';?></title>
</head>
<body class="d-flex flex-column h-100">
   <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <a href="" class="navbar-brand">MON SITE</a>
       
        <ul class="navbar-nav">
            <li class="nav-item">
                 <a href="<?= $router->url('home')?>" class="nav-link" >accueil</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('admin_posts')?>" class="nav-link">Articles</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Catégories</a>
            </li>
            <li class="nav-item">
                 <a href="<?= $router->url('admin_categories')?>" class="nav-link">Utilisateurs</a>
            </li>
            <li class="nav-item">
                 <form action="<?= $router->url('logout')?>" method="post" style="display:inline">
                     <button type="submit" class="btn btn-danger mt-4 " style=" margin-left:55vw"> Se déconnecter</button>
                 </form>
            </li>
        </ul>
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
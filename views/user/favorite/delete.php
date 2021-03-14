<?php 
use App\Connection;
use App\table\FavorieTable;
use App\auth\Auth;
Auth::check_user();
$pdo =Connection::getPDO();
$table = new FavorieTable($pdo);
$table->deleteByUser($_GET['favorie-delete']);
header('Location: ' . $router->url('user_favorie', ['id' => $_SESSION['auth_user']]) . '?delete=1');
?>

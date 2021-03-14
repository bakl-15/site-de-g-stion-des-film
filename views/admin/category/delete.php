<?php 
use App\Connection;
use App\table\CategoryTable;
use App\auth\Auth;
Auth::check_admin();
$pdo =Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete=1');
?>

<?php 
use App\Connection;
use App\table\PostTable;
use App\auth\Auth;
use App\file\PostAttachment;

Auth::check_admin();
$pdo =Connection::getPDO();
$table = new PostTable($pdo);
$post = $table->find($params['id']);
PostAttachment::detach($post);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_posts') . '?delete=1');
?>

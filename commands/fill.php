<?php

// la class facker pour remplir la base de données 

require  dirname(__DIR__) . '/vendor/autoload.php';
use App\Connection;
$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPDO();
 $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
 $pdo->exec('TRUNCATE TABLE post_category');
 $pdo->exec('TRUNCATE TABLE post');
 $pdo->exec('TRUNCATE TABLE category');
 $pdo->exec('TRUNCATE TABLE post_category');
 $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

 $posts = [];
 $categories = [];
 for($i=0; $i < 50; $i++)
 {
  $pdo->exec("INSERT INTO post SET titre ='{$faker->sentence()}' ,slug = '{$faker->slug()}' ,dateCreation= '{$faker->date} {$faker->time}' , description='{$faker->paragraphs(rand(3,15), true)}' ");
  $posts[] = $pdo->lastInsertId();
}
 for($i=0; $i < 5; $i++)
 {
  $pdo->exec("INSERT INTO category SET name ='{$faker->sentence(3)}' ,slug = '{$faker->slug()}'");
  $categories[] = $pdo->lastInsertId();
 }
 foreach($posts as $post)
 {
     $cs = $faker->randomElements($categories, rand(0,count($categories)));
     foreach($cs as $c)
     {
        $pdo->exec("INSERT INTO post_category SET post_id =$post ,category_id = $c");
     }
 }

//  $password = password_hash('admin',PASSWORD_BCRYPT);
//  $pdo->exec("INSERT INTO users SET username='admin' , password = '$password'");
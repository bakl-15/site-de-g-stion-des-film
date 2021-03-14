<?php
namespace App\file;
use App\model\Post;
use Intervention\Image\ImageManager;
class PostAttachment{
    public static function upload(Post $post)
    {
        $image  = $post->getAffiche();
      
          if(empty($image) || $post->shoudUpload() === false){
              return;
          }
          $directory = UPLOAD_PATH . DIRECTORY_SEPARATOR .'post' ;
          if(file_exists($directory) === false){
              mkdir($directory, 0777,true);
          }
           $filename = uniqid("", true) . '.jpeg';
           if(!empty($post->getOldAffiche()))
           {
               $oldFile = $directory . DIRECTORY_SEPARATOR . $post->getOldAffiche();
               if(file_exists($oldFile))
               {
                unlink($oldFile);
               }
              
           }

           //libririe intervention pour les images 
           //$manager = New ImageManager(['driver' => 'gd']);
           //$manager->make($image)
                  // ->fit(350,200)
                   //->save($image, $directory . DIRECTORY_SEPARATOR . $filename . 'small.jpeg');
            
          move_uploaded_file($image, $directory . DIRECTORY_SEPARATOR . $filename);
          $post->setAffiche($filename);
     
    }

    public static function detach(Post $post)
    {
        $directory = UPLOAD_PATH . DIRECTORY_SEPARATOR .'post' ;
        if(!empty($post->getAffiche()))
        {
            $File = $directory . DIRECTORY_SEPARATOR . $post->getOldAffiche();
            if(file_exists($File))
            {
             unlink($File);
            }
           
        }
    }
}
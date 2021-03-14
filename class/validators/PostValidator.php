<?php
namespace App\validators;
use Valitron\Validator;
use App\table\PostTable;

class PostValidator extends AbstractValidator
{

    public function __construct(array $data, PostTable $table, ?int $postID = null,array $categories)
    {
        parent::__construct($data);

        Validator::addRule('image',function($field, $value, array $params, array $fields){
            if($value['size'] === 0){
                return true;
            }
            $mimes = ['image/jpeg','image/png'];
            $finfo = new \finfo();
            $info = $finfo->file($value['tmp_name'], FILEINFO_MIME_TYPE);
            return in_array($info, $mimes);
            return false;
       }, 'Le fichier n\'est pas une image valide'); 

        $this->validator->rule('required', ['titre','slug']);
        $this->validator->rule('lengthBetween', ['titre','slug'], 3, 200);
        $this->validator->rule('slug','slug');
        $this->validator->rule('image', 'image');
        $this->validator->rule('subset', 'categories_ids',array_keys($categories) );
        $this->validator->rule(function($field, $value) use ($table, $postID) {
              return  !$table->exists($field, $value, $postID);
        }, ['slug', 'titre'], 'est déja utilisé');
         $this->validator->labels([
           'titre' => 'Ce Titre',
           'slug' => 'Cet URL',
           'description' => 'description',
       ]);

    }
   

}
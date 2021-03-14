<?php
namespace App\validators;

use App\table\CategoryTable;
use App\table\UserTable;
use Valitron\Validator;
class UserValidator extends AbstractValidator
{
    protected $data;
    public function __construct(array $data, UserTable $table , ?int $id = null)
    {
        $this->data = $data;
          
        parent::__construct($data);
         
         
        Validator::addRule('same', function ($field, $value, $params) {
            dump($value);
            if($value === $this->data['password']){return true;}
         
              return false;
        }, 'Les mots de passe ne sont pas identique ');
        
       


    
       // $this->validator->rule('required', ['Nom d\'utilisateur','Mot de passe','email','genre','Date de naissance']);
        $this->validator->rule('lengthBetween', ['username'],3 , 200);
        $this->validator->rule('lengthBetween', ['password'], 6, 200);
        $this->validator->rule('email','email');
        $this->validator->rule('same', [ 'confirm']);
       // $this->validator->rule('regex', 'password', '/^[a-zA-Z0-9]{5,20}$/');
        //$this->validator->rule('accepted','cgu');
        $this->validator->rule('equals','[password]');
        $this->validator->rule(function($field, $value) use ($table) {
              return  !$table->exists($field, $value);
        }, ['username'], 'est déja utilisé');
         $this->validator->labels([
           'name' => 'Ce Titre',
           'slug' => 'Cet URL',
           'content' => 'Contenu',
           'password' => '',
           'confirm'  => '',
       ]);

    }
   

}
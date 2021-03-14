<?php
namespace App\validators;

use App\table\CategoryTable;

class CategoryValidator extends AbstractValidator
{

    public function __construct(array $data, CategoryTable $table, ?int $id = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name','slug']);
        $this->validator->rule('lengthBetween', ['name','slug'], 3, 200);
        $this->validator->rule('slug','slug');
        $this->validator->rule(function($field, $value) use ($table, $id) {
              return  !$table->exists($field, $value, $id);
        }, ['slug', 'name'], 'est déja utilisé');
         $this->validator->labels([
           'name' => 'Ce Titre',
           'slug' => 'Cet URL',
           'content' => 'Contenu',
       ]);

    }
   

}
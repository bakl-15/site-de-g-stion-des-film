<?php
namespace App\table;
use \Exception;
class NotFoundException extends Exception{
     
    public function __construct(string $table)
    {
          $this->message = "Aucun enregistrement ne correspond à l'ID  dans la table $table " ;
    }




}
<?php
namespace App\model;
class Category
{
    private $id;
    private $slug;
    private $name;
    private $post_id;

    public function setID(int $id):self
    {
       $this->id = $id;
       return $this;
    
    }
    public function setName(string $name):self
    {
       $this->name = $name;
       return $this;
    
    }
    public function setSlug(string $slug):self
    {
       $this->slug = $slug;
       return $this;
    
    }
   
    public function getID() :?int
    {
        return $this->id;
    }

    public function getSlug() :?string
    {
        return $this->slug;
    }

    public function getName()  :?string
    {
        return $this->name;
    }

    public function getPost_id(): ?string{
        return $this->post_id;
    }
}
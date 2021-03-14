<?php 
namespace App\model;
use App\helpers\Text;
use \DateTime;
class Post{
  
    private $id;
    private $titre;
    private $description;
    private $auteur;
    private $categories = [];
    private $slug;
    private $dateSortir;
    private $dateCreation;
    private $dateModification;
    private $affiche;
    private $oldAffiche;
    private $pendingUpload = false;




    //-------- SETTER---------------------
    public function setID(int $id):self
    {
       $this->id = $id;
       return $this;
    }

    public function setTitre(string $titre):self
    {
       $this->titre = $titre;
       return $this;
    }
    public function setDescription(string $description):self
    {
       $this->description = $description;
       return $this;
       
    }
    public function setAuteur(string $auteur):self
    {
       $this->auteur = $auteur;
       return $this;
    
    }

    public function setDateCreation(string $dateCreation ) :self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    } 
    public function setDateSortir(string $dateSortir ) :self
    {
        $this->dateSortir = $dateSortir;
        return $this;
    }
    public function setDateModification(string $dateSortir ) :self
    {
        $this->dateSortir = $dateSortir;
        return $this;
    }
  
    public function setOldAfiche(string $oldAffiche ) :self
    {
        $this->oldAffiche = $oldAffiche;
        return $this;
    }




//-----GETTER---------------------
    public function getID(): ?int
    {
       return $this->id;
    }

    public function getTitre() : string
    {
        return htmlentities($this->titre) ;
    }

    public function getDescription()
    {  
       return $this->description;
    }
  
    public function getExcerpt() : string
    {
        if($this->description === null)
        {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->description, 60)));
    }
    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function getDateSortir() : DateTime
    {
        return new DateTime($this->dateSortir);
    }
    public function getDateModification() : DateTime
    {
        return new DateTime($this->dateModification);
    }
    public function getdateCreation() : DateTime
    {
        return new DateTime($this->dateCreation);
    }
   
   
    public  function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->description));
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
        //$category->setPost($this);
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
    public function setCategories(array $categories): self
    {
       $this->categories  = $categories;
       return $this;
    }
    public function getCategoriesIDs():array
    {
       $ids = [];
       foreach($this->categories as $category)
       {
           $ids[] = $category->getID();
       }
       return $ids;
    }

     public function getAffiche(): ?string
     {
         return $this->affiche;
     }
     public function setAffiche($affiche):self
     {
         if(is_array($affiche) && !empty($affiche['tmp_name'] ))
         {
             if(!empty($this->affiche))
             {
                  $this->oldAffiche = $this->affiche;
             }
             $this->pendingUpload = true;
            $this->affiche = $affiche['tmp_name'] ;
         }

         if(is_string($affiche) && !empty($affiche))
         {
            $this->affiche = $affiche;
         }
        
         return $this;
     }
     public function  getOldAffiche(): ?string
     {
         return $this->oldAffiche;
     }
       
    public function shoudUpload(): bool
    {
      return $this->pendingUpload;
    }
    public function getAfficheUrl(): ?string
    {
        if(empty($this->affiche)){
            return null;
        }
        return '/uploads/post/' . $this->affiche;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
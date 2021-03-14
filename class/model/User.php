<?php
namespace App\model;

use DateTime;

class User{
    private  $id;
    private $username;
    private $password;
    private $confirm;
    private $email;
    private $genre;
    private $role;
    private $avatar = null;
    private $dateNaissance;
    private $cgu;
    private $dateCreation;
    private $dateModification;
   


    /**
     * Get the value of password
     */ 
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get the value of username
     *
     */ 
    public function getUsername():?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the value of password
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) :self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email):self
    {
        $this->email = $email;

        return $this;
    }

    
    public function getGenre():?string
    {
        return $this->genre;
    }

    public function setGenre($genre):self
    {
        $this->genre = $genre;

        return $this;
    }

    
    public function getRole(): ?string
    {
        return $this->role;
    }

    
    public function setRole($role): ?self
    {
        $this->role = $role;

        return $this;
    }

  
    public function getAvatar():?string
    {
        return $this->avatar;
    }

   
    public function setAvatar($avatar):self
    {
        $this->avatar = $avatar;

        return $this;
    }

   
    public function getDateNaissance(): ?DateTime
    {
        return new DateTime($this->dateNaissance);
    }

   
    public function setDateNaissance($dateNaissance):self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

   
    public function getCgu():?array
    {
        return $this->cgu;
    }

   
    public function setCgu($cgu):self
    {
        $this->cgu = $cgu;

        return $this;
    }

   
    public function getDateCreation():?DateTime
    {
        return new datetime($this->dateCreation);
    }

    
    public function setDateCreation($dateCreation):self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

   
    public function getDateModification():?DateTime
    {
        return new Datetime($this->dateModification);
    }

    
    public function setDateModification($dateModification):self
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get the value of passwordConfirm
     */ 
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     * Set the value of passwordConfirm
     *
     * @return  self
     */ 
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    /**
     * Get the value of confirm
     */ 
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * Set the value of confirm
     *
     * @return  self
     */ 
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;

        return $this;
    }
}
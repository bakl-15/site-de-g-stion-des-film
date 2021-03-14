<?php
namespace App\model;
class Favorie
{
    private $id;
    private $filmID;
    private $userID;


    /**
     * Get the value of id
     */ 
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of filmID
     */ 
    public function getFilmID(): ?int
    {
        return $this->filmID;
    }

    /**
     * Set the value of filmID
     *
     * @return  self
     */ 
    public function setFilmID($filmID)
    {
        $this->filmID = $filmID;

        return $this;
    }

    /**
     * Get the value of userID
     */ 
    public function getUserID(): ?int
    {
        return $this->userID;
    }

    /**
     * Set the value of userID
     *
     * @return  self
     */ 
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }
}
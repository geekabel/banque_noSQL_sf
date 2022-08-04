<?php

namespace App\Document;


use MongoDB\Collection;
use App\Document\Compte;
use App\Document\TypeCompte;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * The bank allows its customers to open and manage accounts.
 * @MongoDB\Document(collection="banque")
 */
class Banque {

    /**
     * @MongoDB\Id
     */
     private $id;

    /**
     * @MongoDB\Field(type="string")
     */
     private Compte $comptes;

    /**
     * @MongoDB\Field(type="string")
     */
    private TypeCompte $typecomptes;


     public function __construct($comptes, $typecomptes)
     {
         $this->comptes = $comptes;
         $this->typecomptes = $typecomptes;
     }
    
    public function getId(): ?string
    {
        return $this->id;
    }
    
}
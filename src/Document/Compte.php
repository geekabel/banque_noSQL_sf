<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="compte")
 */
class Compte
{

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $numagence;

    /**
     * @MongoDB\Field(type="string")
     */
    private $numcompte;

    /**
     * @MongoDB\Field(type="string")
     */
    private $solde;

    /**
     * @MongoDB\Field(type="string")
     */
    private TypeCompte $typecomptes;




    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNumagence(): ?string
    {
        return $this->numagence;
    }

    public function setNumagence(string $numagence): self
    {
        $this->numagence = $numagence;

        return $this;
    }

    public function getNumcompte(): ?string
    {
        return $this->numcompte;
    }

    public function setNumcompte(string $numcompte): self
    {
        $this->numcompte = $numcompte;

        return $this;
    }

    public function getSolde(): ?string
    {
        if ($this->solde < 0) {
            $this->solde = 0;
        }

        return $this->solde;
    }

    public function setSolde(string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getTypecomptes(): ?TypeCompte
    {
        return $this->typecomptes;
    }

    public function setTypecomptes(?TypeCompte $typecomptes): self
    {
        $this->typecomptes = $typecomptes;

        return $this;
    }


    // add money on the account
    public function addMoney($amount)
    {
        $this->solde += $amount;
    }

    // remove money from the account
    public function removeMoney($amount)
    {
       
        if ($amount > $this->solde) {
            $this->solde = 0;
        } else {
            $this->solde -= $amount;
        }
    }

    /**
     *  Increase the balance of this account by M * T for each deposit of money of amount M 
     */
    
    public function calculerInteret($montant, $taux)
    {
        // if typeCompte is savings
        if ($this->getTypecomptes()->getLibelle() == "Epargne") {
            $this->solde += $montant * $taux;
        }

        return $this->solde;
    }


}

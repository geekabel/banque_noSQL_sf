<?php

namespace App\Document;

use App\Document\Compte;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceMany;


/**
 * @MongoDB\Document(collection="client")
 */
class Client
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $nom;

    /**
     * @MongoDB\Field(type="string")
     */
    private $prenom;

    /**
     * @MongoDB\Field(type="string")
     */
    private $adresse;

    /**
     * @MongoDB\Field(type="string")
     */
    private $telephone;

    /**
     * @ReferenceMany(targetDocument="Compte::class", mappedBy="idClients")
     */
    private Collection $comptes;

    /**
     * @MongoDB\Field(type="string")
     */
    private Banque $banques;

    public function __construct()
    {
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function setComptes(Collection $comptes): self
    {
        $this->comptes = $comptes;

        return $this;
    }


    public function getBanques(): ?Banque
    {
        return $this->banques;
    }

    public function setBanques(?Banque $banques): self
    {
        $this->banques = $banques;

        return $this;
    }

    // customer must be able to transfer funds from one current account to another of his or her accounts (current or savings).

    public function transferFunds($amount, $from, $to)
    {
        if ($from->getSolde() >= $amount) {
            $from->setSolde($from->getSolde() - $amount);
            $to->setSolde($to->getSolde() + $amount);
        }
    }

    // A customer must be able to transfer funds to another customer's account by paying a given price per transaction.

    public function transferFundsToAnotherCustomer($amount, $from, $to, $price)
    {
        if ($from->getSolde() >= $amount + $price) {
            $from->setSolde($from->getSolde() - $amount - $price);
            $to->setSolde($to->getSolde() + $amount);
        }
    }
}

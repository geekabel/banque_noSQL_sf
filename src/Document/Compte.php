<?php

namespace App\Document;

use App\Document\Client;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(collection="compte", repositoryClass="App\Repository\CompteRepository")
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
     * @MongoDB\Field(type="float")
     */
    private $solde;

    /**
     * @ReferenceOne(targetDocument="Client::class", inversedBy="comptes")
     */
    private $idClients;

    /**
     * @MongoDB\Field(type="float")
     */
    private $taux = 0.5;

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

    public function getSolde(): ?float
    {
        if ($this->solde < 0) {
            $this->solde = 0;
        }

        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

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

    public function getIdClients(): ?Client
    {
        return $this->idClients;
    }

    public function setIdClients(?Client $idClients): self
    {
        $this->idClients = $idClients;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): self
    {
        $this->taux = $taux;

        return $this;
    }
}

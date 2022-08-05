<?php

namespace App\Document;

use App\Document\Compte;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="compte_epargne")
 */
class CompteEpargne extends Compte
{


    /**
     * @MongoDB\Field(type="float")
     */
    private $taux = 0.5;

    
    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): self
    {
        $this->taux = $taux;

        return $this;
    }
    /**
     *  Increase the balance of this account by M * T for each deposit of money of amount M
     */
    public function calculerInteret($montant, $taux)
    {
        $this->solde += $montant * $taux;

        return $this->solde;
    }
}

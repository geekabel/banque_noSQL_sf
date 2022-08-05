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
     *  Increase the balance of this account by M * T for each deposit of money of amount M
     */

    public function calculerInteret($montant, $taux)
    {
        $this->solde += $montant * $taux;

        return $this->solde;
    }
}

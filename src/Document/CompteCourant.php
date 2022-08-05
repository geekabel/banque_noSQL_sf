<?php

namespace App\Document;


use App\Document\Compte;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


/**
 * @MongoDB\Document(collection="compte_courant")
 */
class CompteCourant extends Compte
{

    /**
     * @MongoDB\Id
     */
    private $id;


   
}
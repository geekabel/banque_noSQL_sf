<?php

namespace App\Repository;

use App\Document\Compte;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class CompteRepository extends DocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
     //   parent::__construct($registry, Compte::class);
    }

}
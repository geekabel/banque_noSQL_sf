<?php

namespace App\Repository;

use App\Document\Compte;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class CompteRepository extends DocumentRepository
{

    public function __construct(DocumentManager $dm)
    {
        $uow = $dm->getUnitOfWork();
        $classMetaData = $dm->getClassMetadata(Compte::class);
        parent::__construct($dm, $uow, $classMetaData);
    }

    public function findSoldeByNumCompte($numCompte)
    {
        $compte = $this->createQueryBuilder('c')
            ->field('numcompte')->equals($numCompte)
            ->getQuery()
            ->getSingleResult();

        return $compte->getSolde();
    }
}

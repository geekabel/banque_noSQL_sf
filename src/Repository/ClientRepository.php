<?php

namespace App\Repository;

use MongoDB\Client;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class ClientRepository extends DocumentRepository
{
    public function __construct(DocumentManager $dm)
    {
        $uow = $dm->getUnitOfWork();
        $classMetaData = $dm->getClassMetadata(Client::class);
        parent::__construct($dm, $uow, $classMetaData);
    }
}

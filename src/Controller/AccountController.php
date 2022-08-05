<?php

namespace App\Controller;

use App\Document\Client;
use App\Document\Compte;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class AccountController extends AbstractController
{

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @Route("/add/{amount}", name="add_amount", methods={"POST"})
     */
    public function addMoneyOnAccount($amount)
    {

        $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => '123456789']);
        $compte->setSolde($compte->getSolde() + $amount);
        $this->dm->persist($compte);
        $this->dm->flush();

        return $this->json([
            'message' => 'Amount added successfully',
            'amount' => $amount,
            'new_balance' => $compte->getSolde(),
        ], 201);
    }

    /**
     * @Route("/list", name="account_list", methods={"GET"})
     */
    public function listAccount()
    {

        $account = $this->dm->getRepository(Client::class)->findAll();

        $befJson = [];
        $nom = $account->getNom() . $account->getNom();
        $adresse = $account->getAdresse()
            ->getNumcompte();
        //$numCompte = $account->getNumcompte();
       

        return $this->json($nom);
    }
}

<?php

namespace App\Controller;

use App\Document\Compte;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/add/{amount}/{numcompte}", name="add_amount", methods={"POST"})
     */
    public function addMoneyOnAccount($amount, $numcompte)
    {

        $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte]);
        $compte->setSolde($compte->getSolde() + $amount);
        $this->dm->persist($compte);
        $this->dm->flush();

        return $this->json([
            'message' => 'Votre compte a été crédité de ' . $amount . '€' . ' avec succès !',
            'amount' => $amount,
            'new_balance' => $compte->getSolde(),
        ], 201);
    }

    /**
     * @Route("/subtract/{amount}/{numcompte}", name="subtract_amount", methods={"POST"})
     */
    public function subtractMoneyFromAccount($amount, $numcompte)
    {

        $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte]);
        $compte->setSolde($compte->getSolde() - $amount);
        $this->dm->persist($compte);
        $this->dm->flush();

        return $this->json([
            'message' => 'Votre compte a été débité de ' . $amount . '€' . 'avec succès !',
            'amount' => $amount,
            'new_balance' => $compte->getSolde(),
        ], 201);
    }

    /**
     * @Route("/transfer/{amount}/{numcompte}/{numcompte_dest}", name="transfer_amount", methods={"POST"})
     */
    public function transferMoney($amount, $numcompte, $numcompte_dest)
    {

        $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte]);
        $compte_dest = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte_dest]);
        $compte->setSolde($compte->getSolde() - $amount);
        $compte_dest->setSolde($compte_dest->getSolde() + $amount);
        $this->dm->persist($compte);
        $this->dm->persist($compte_dest);
        $this->dm->flush();

        return $this->json([
            'message' => 'Le compte ' . $compte->getNumcompte() . ' a été débité de ' . $amount . '€' . 'avec succès !',
            'amount' => $amount,
            'compte' => '',
            'new_balance' => $compte->getSolde(),
        ], 201);
    }

    /**
     * @Route("/transfer/{amount}/{numcompte}/{numcompte_dest}/{transactioncosts}", name="transfer_amount", methods={"POST"})
     */
    public function transferFundsToAnotherCustomer($amount, $numcompte, $numcompte_dest, $transactioncosts)
    {       
            $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte]);
            $compte_dest = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte_dest]);
            $compte->setSolde($compte->getSolde() - ($amount + $transactioncosts));
            $compte_dest->setSolde($compte_dest->getSolde() + $amount);
            $this->dm->persist($compte);
            $this->dm->persist($compte_dest);
            $this->dm->flush();
    
            return $this->json([
                'message' => 'Le compte ' . $compte->getNumcompte() . ' a été débité de ' . $amount . '€' . 'et' . $transactioncosts. ' avec succès !',
                'amount' => $amount + $transactioncosts,
                'new_balance' => $compte->getSolde(),
            ], 201);
    }

    /**
     * @Route("/list/{numcompte}", name="list_account", methods={"GET"})
     */
    public function listSoldeAccount($numcompte)
    {
        $solde = $this->dm->getRepository(Compte::class)->findSoldeByNumCompte($numcompte);
        // dd($solde);
        if ($solde == null && $solde < 0) {
            $solde = 0;

            return $this->json([
                'message' => 'Le solde de votre compte est insuffisant !',
                'solde' => 'Le solde de votre compte s\'eleve à ' . $solde . '€',
            ], 200);
        }

        return $this->json([
            'message' => 'Le solde de votre compte est de ' . $solde . '€',
            'solde' => $solde . '€',
        ], 200);
    }
     /**
     *  
     * @Route("/interest/{numcompte}/{taux}", name="interest_account", methods={"POST"})
     */
    public function creditSavingAccount(string $numcompte, $taux) {
        $compte = $this->dm->getRepository(Compte::class)->findOneBy(['numcompte' => $numcompte]);
        $compte->setSolde($compte->getSolde() + ($compte->getSolde() * $taux));
        $this->dm->persist($compte);
        $this->dm->flush();

        return $this->json([
            'message' => 'Le compte ' . $compte->getNumcompte() . ' a été crédité de ' . $compte->getSolde() * $taux . '€' . ' avec succès !',
            'amount' => 'Montant de l\'intérêt ' . $compte->getSolde() * $taux,
            'new_balance' => 'Nouveau solde' . $compte->getSolde() . '€',
        ], 201);
    }

}

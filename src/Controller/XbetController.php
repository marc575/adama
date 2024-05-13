<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Retrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class XbetController extends AbstractController
{

    #[Route('/xbet/depot', name: 'depot')]
    public function depot(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer, HttpClientInterface $client)
    {
        $msg = null;
        if($request->isMethod(Request::METHOD_POST)) 
        {
            $email = $request->request->get('Email');
            $id_compte = $request->request->get('Id_Compte');
            $montant = $request->request->get('Montant');
            $id_transaction = $request->request->get('Id_Transaction');
            $numero_paiement = $request->request->get('Numero_Paiement');
            $pays = $request->request->get('Pays');

            if(!preg_match("#.{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,5}#", $email))
            {
                $msg = "Ajoutez une adresse mail valide";
            }
            if(!$id_compte || strlen($id_compte) < 8)
            {
                $msg = "Precisez l'identifiant exacte de votre compte 1xbet";

            }
            if(!$numero_paiement || strlen($numero_paiement) < 8)
            {
                $msg = "Renseignez votre numéro de paiement";

            }
            if($montant < 500)
            {
                $msg = "Le montant minimal est de 500 XOF";

            }
            if(!$id_transaction || strlen($id_transaction) < 8)
            {
                $msg = "Precisez le numéro de votre ID de transaction";

            }

            $depot = new Depot();
            $depot->setEmail($email);
            $depot->setIdCompte($id_compte);
            $depot->setMontant($montant);
            $depot->setIdTransaction($id_transaction);
            $depot->setNumeroPaiement($numero_paiement);
            $depot->setPays($pays);
            $depot->setDate(new \DateTime('now'));

            $em = $doctrine->getManager();
            $em->persist($depot);
            $em->flush();
            
            $message = "Détails du dépot : Email = " .$email. ", Identifiant du compte = " .$id_compte. ", Pays = " .$pays. ", Montant = " .$montant. ", Identifiant de la transaction = " .$id_transaction. ", Numero de paiement = " .$numero_paiement. ".";
            $whatsapp = "https://api.whatsapp.com/send/?phone=2250708618478&text=" .$message. "..";

            return $this->redirect($whatsapp);
        }
        return $this->render('depot.html.twig', compact('msg'));
    }

    #[Route('/xbet/retrait', name: 'retrait')]
    public function retrait(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer) : Response
    {
        $msg = null;
        if($request->isMethod(Request::METHOD_POST)) 
        {
            $email = $request->request->get('Email');
            $id_compte = $request->request->get('Id_Compte');
            $montant = $request->request->get('Montant');
            $code_recu = $request->request->get('Code_Recu');
            $numero_recu = $request->request->get('Numero_Recu');
            $cnumero_recu = $request->request->get('CNumero_Recu');
            $pays = $request->request->get('Pays');

            if(!preg_match("#.{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,5}#", $email))
            {
                $msg = "Ajoutez une adresse mail valide";

                return $this->render('retrait.html.twig', compact('msg'));
            }
            if(!$id_compte || strlen($id_compte) < 8)
            {
                $msg = "Precisez l'identifiant exacte de votre compte 1xbet";

                return $this->render('retrait.html.twig', compact('msg'));
            }
            if(!$numero_recu || strlen($numero_recu) < 8)
            {
                $msg = "Renseignez le numéro de reçu exacte";

                return $this->render('retrait.html.twig', compact('msg'));
            }
            if($montant < 3000)
            {
                $msg = "Le montant minimal est de 3000 XOF";

                return $this->render('retrait.html.twig', compact('msg'));
            }
            if(!$cnumero_recu || $cnumero_recu != $numero_recu)
            {
                $msg = "Vérifier bien la confirmation de votre numero de reçu";

                return $this->render('retrait.html.twig', compact('msg'));
            }

            $retrait = new Retrait();
            $retrait->setEmail($email);
            $retrait->setIdCompte($id_compte);
            $retrait->setMontant($montant);
            $retrait->setCodeRecu($code_recu);
            $retrait->setNumeroRecu($cnumero_recu);
            $retrait->setCnumeroRecu($numero_recu);
            $retrait->setPays($pays);
            $retrait->setDate(new \DateTime('now'));

            $em = $doctrine->getManager();
            $em->persist($retrait);
            $em->flush();
            
            $message = "Détails du retrait : Email = " .$email. ", Identifiant du compte = " .$id_compte. ", Pays = " .$pays. ", code du reçu = "  .$code_recu. ", Montant = " .$montant. ", Numéro de reçu = " .$numero_recu. ", Confirmation du numéro de reçu = " .$cnumero_recu. ".";
            $whatsapp = "https://api.whatsapp.com/send/?phone=2250708618478&text=" .$message. "..";

            return $this->redirect($whatsapp);

        }   

        return $this->render('retrait.html.twig', compact('msg'));
    }
}

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
            $email = $request->request->get('email');
            $id_compte = $request->request->get('id_compte');
            $montant = $request->request->get('montant');
            $id_transaction = $request->request->get('id_transaction');
            $numero_paiement = $request->request->get('numero_paiement');
            $pays = $request->request->get('pays');

            if(!preg_match("#.{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,5}#", $email))
            {
                $msg = "Ajoutez une adresse mail valide";

                return $this->render('depot.html.twig', compact('msg'));
            }
            if(!$id_compte || strlen($id_compte) < 8)
            {
                $msg = "Precisez l'identifiant exacte de votre compte 1xbet";

                return $this->render('depot.html.twig', compact('msg'));
            }
            if(!$numero_paiement || strlen($numero_paiement) < 8)
            {
                $msg = "Renseignez votre numéro de paiement";

                return $this->render('depot.html.twig', compact('msg'));
            }
            if($montant < 500)
            {
                $msg = "Le montant minimal est de 500 XOF";

                return $this->render('depot.html.twig', compact('msg'));
            }
            if(!$id_transaction || strlen($id_transaction) < 8)
            {
                $msg = "Precisez le numéro de votre ID de transaction";

                return $this->render('depot.html.twig', compact('msg'));
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

            $c_email = (new TemplatedEmail())
                ->to($email)
                ->subject('BS Exchange Services | Bon de commande de votre recharge 1XBET')
                ->htmlTemplate('email/depot.html.twig')
                ->context([
                    'id_compte' => $id_compte,
                    'montant' => $montant,
                    'id_transaction' => $id_transaction,
                    'numero_paiement' => $numero_paiement,
                    'pays' => $pays,          
                ]);
    
            $mailer->send($c_email);

            $v_email = (new TemplatedEmail())
                ->to('barryadamagd@gmail.com')
                ->subject('BS Exchange Services | Bon de commande pour une nouvelle recharge 1XBET')
                ->htmlTemplate('email/depot.html.twig')
                ->context([
                    'id_compte' => $id_compte,
                    'montant' => $montant,
                    'id_transaction' => $id_transaction,
                    'numero_paiement' => $numero_paiement,
                    'pays' => $pays,                    
                ]);
    
            $mailer->send($v_email);

            return $this->redirect('https://api.whatsapp.com/send?phone=2250708618478&amp;text=Id_compte=$id_compte%0Montant=$montant%0Id_transaction=$id_transaction%0Numero_paiement=$numero_paiement%0Pays=$pays');
        }

        return $this->render('depot.html.twig', compact('msg'));

    }

    #[Route('/xbet/retrait', name: 'retrait')]
    public function retrait(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer) : Response
    {
        $msg = null;
        if($request->isMethod(Request::METHOD_POST)) 
        {
            $email = $request->request->get('email');
            $id_compte = $request->request->get('id_compte');
            $montant = $request->request->get('montant');
            $code_recu = $request->request->get('code_recu');
            $numero_recu = $request->request->get('numero_recu');
            $cnumero_recu = $request->request->get('cnumero_recu');
            $pays = $request->request->get('pays');

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

            $c_email = (new TemplatedEmail())
                ->to($email)
                ->subject('BS Exchange Services | Bon de commande de votre retrait 1XBET')
                ->htmlTemplate('email/retrait.html.twig')
                ->context([
                    'id_compte' => $id_compte,
                    'montant' => $montant,
                    'code_recu' => $code_recu,
                    'numero_recu' => $numero_recu,
                    'pays' => $pays,
                ]);
    
            $mailer->send($c_email);

            $v_email = (new TemplatedEmail())
                ->to('barryadamagd@gmail.com')
                ->subject('BS Exchange Services | Bon de commande pour un nouveau retrait 1XBET')
                ->htmlTemplate('email/retrait.html.twig')
                ->context([
                    'id_compte' => $id_compte,
                    'montant' => $montant,
                    'code_recu' => $code_recu,
                    'numero_recu' => $numero_recu,
                    'pays' => $pays,
                ]);
    
            $mailer->send($v_email);

            return $this->redirect('https://wa.me/2250708618478/?text=Bonjour%20Mr%2C%20je%20viens%20d%27effectuer%20un%20retrait%201XBET%20via%20votre%20site%20bsexchangeservices.com%20');
        }

        return $this->render('retrait.html.twig', compact('msg'));
    }
}

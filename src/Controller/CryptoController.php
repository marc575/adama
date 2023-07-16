<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CryptoController extends AbstractController
{
    #[Route('/cryptomonnaie/achat', name: 'achat')]
    public function achat(): Response
    {
        return $this->render('achat.html.twig');
    }

    #[Route('/cryptomonnaie/vente', name: 'vente')]
    public function vente(): Response
    {
        return $this->render('vente.html.twig');
    }

    #[Route('/cryptomonnaie/echange', name: 'echange')]
    public function echange(): Response
    {
        return $this->render('echange.html.twig');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CoinGeckoService;

class CryptoController extends AbstractController
{
    private $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    #[Route('/cryptomonnaie/achat', name: 'achat')]
    public function achat(): Response
    {
        
        $trending = $this->coinGeckoService->getTrendingCoins();
        $prices = $this->coinGeckoService->getRealTimePrices(['bitcoin', 'ethereum', 'tether']);
        $history = $this->coinGeckoService->getMarketHistory('bitcoin');

        return $this->render('achat.html.twig', [
            'trending' => $trending,
            'prices' => $prices,
            'history' => $history,
        ]);
    }

    #[Route('/cryptomonnaie/vente', name: 'vente')]
    public function vente(): Response
    {
        
        $trending = $this->coinGeckoService->getTrendingCoins();
        $prices = $this->coinGeckoService->getRealTimePrices(['bitcoin', 'ethereum', 'tether']);
        $history = $this->coinGeckoService->getMarketHistory('bitcoin');

        return $this->render('vente.html.twig', [
            'trending' => $trending,
            'prices' => $prices,
            'history' => $history,
        ]);
    }

    #[Route('/cryptomonnaie/echange', name: 'echange')]
    public function echange(): Response
    {
        
        $trending = $this->coinGeckoService->getTrendingCoins();
        $prices = $this->coinGeckoService->getRealTimePrices(['bitcoin', 'ethereum', 'tether']);
        $history = $this->coinGeckoService->getMarketHistory('bitcoin');
        
        return $this->render('echange.html.twig', [
            'trending' => $trending,
            'prices' => $prices,
            'history' => $history,
        ]);
    }
}

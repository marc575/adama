<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CoinGeckoService;

class HomeController extends AbstractController
{
    private $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $trending = $this->coinGeckoService->getTrendingCoins();
        $prices = $this->coinGeckoService->getRealTimePrices(['bitcoin', 'ethereum', 'tether']);
        $history = $this->coinGeckoService->getMarketHistory('bitcoin');

        return $this->render('index.html.twig', [
            'trending' => $trending,
            'prices' => $prices,
            'history' => $history,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        $trending = $this->coinGeckoService->getTrendingCoins();
        $prices = $this->coinGeckoService->getRealTimePrices(['bitcoin', 'ethereum', 'tether']);
        $history = $this->coinGeckoService->getMarketHistory('bitcoin');
        return $this->render('about.html.twig', [
            'trending' => $trending,
            'prices' => $prices,
            'history' => $history,
        ]);
    }
}

<?php

// src/Service/CoinGeckoService.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoinGeckoService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getTrendingCoins(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.coingecko.com/api/v3/search/trending'
        );
        return $response->toArray();
    }

    public function getRealTimePrices(array $coins, string $currency = 'usd'): array
    {
        $ids = implode(',', $coins);
        $url = "https://api.coingecko.com/api/v3/simple/price?ids=$ids&vs_currencies=$currency";
        $response = $this->client->request('GET', $url, [
            // 'query' => [
            //     'ids' => implode(',', $coins),
            //     'vs_currencies' => 'usd',
            // ],
        ]);
        return $response->toArray();
    }

    public function getMarketHistory(string $coinId, int $days = 30, string $currency = 'usd'): array
    {
        $url = "https://api.coingecko.com/api/v3/coins/$coinId/market_chart?vs_currency=$currency&days=$days";
        $response = $this->client->request('GET', $url);
        return $response->toArray();
    }
}

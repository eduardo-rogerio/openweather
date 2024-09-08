<?php

declare(strict_types=1);

namespace Vagrant\Openweather\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OpenWeatherService
{
    protected Client $client;

    protected string $apiKey;

    protected array $queryParams;

    protected array $response;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openweathermap.org/data/3.0/'
        ]);

        $this->apiKey = $_ENV['OPENWEATHER_API_KEY'];
    }

    public function city(string $city): self
    {
        $this->queryParams['q'] = $city;
        return $this;
    }

    public function coordinates(float $lat, float $lon): self
    {
        $this->queryParams['lat'] = $lat;
        $this->queryParams['lon'] = $lon;
        return $this;
    }

    public function fetchCurrentWeather(): self
    {
        try {
            $this->queryParams['appid'] = $this->apiKey;
            $this->queryParams['units'] = 'metric';
            $this->queryParams['lang'] = 'pt_br';

            $response = $this->client->request('GET', 'onecall',[
                'query' => $this->queryParams,
            ]);

            $this->response = json_decode($response->getBody()->__toString(), true);
        } catch (RequestException $e) {
            $this->response = ['Erro ao buscar os dados do clima: ' . $e->getMessage()];
        }

        return $this;
    }

    public function get(): array
    {
        return $this->response;
    }
}
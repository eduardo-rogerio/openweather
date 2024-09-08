<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use Vagrant\Openweather\Service\OpenWeatherService;

$dotenv = Dotenv::createImmutable(__DIR__, '.env');
$dotenv->load();

$weather = new OpenWeatherService;

$weather->coordinates(33.44, 94.04)
    ->fetchCurrentWeather()
    ->get();

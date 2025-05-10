<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Get current weather data for a specific location.
     */
    public function getWeather(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?lat=%s&lon=%s&appid=%s&units=metric&lang=fr',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get 5-day weather forecast for a specific location.
     */
    public function getFiveDayForecast(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/forecast?lat=%s&lon=%s&appid=%s&units=metric&lang=fr',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get historical weather data for a specific location and timestamp.
     */
    public function getHistoricalWeather(float $latitude, float $longitude, int $timestamp): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/onecall/timemachine?lat=%s&lon=%s&dt=%s&appid=%s&units=metric&lang=fr',
            $latitude,
            $longitude,
            $timestamp,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get air pollution data for a specific location.
     */
    public function getAirPollution(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/air_pollution?lat=%s&lon=%s&appid=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get UV index data for a specific location.
     */
    public function getUVIndex(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/uvi?lat=%s&lon=%s&appid=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get geocoding data (convert location name to coordinates).
     */
    public function getCoordinates(string $locationName): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/geo/1.0/direct?q=%s&limit=1&appid=%s',
            $locationName,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get reverse geocoding data (convert coordinates to location name).
     */
    public function getLocationName(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/geo/1.0/reverse?lat=%s&lon=%s&limit=1&appid=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }

    /**
     * Get weather alerts for a specific location.
     */
    public function getWeatherAlerts(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/onecall?lat=%s&lon=%s&exclude=current,minutely,hourly,daily&appid=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }
}
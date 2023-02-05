<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    private LocationRepository $locationRepository;
    private MeasurementRepository $measurementRepository;

    public function __construct(LocationRepository $locationRepository, MeasurementRepository $measurementRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    public function getWeatherForCountryAndCity($countryCode, $cityName): array
    {
        $cityrep = $this->locationRepository->findBy([
            'country' => $countryCode,
            'city' => $cityName,
        ]);

        return $this->getWeatherForLocation($cityrep[0]);
    }

    public function getWeatherForLocation($location): array
    {
        if (gettype($location) == 'string') {
            $location = $this->locationRepository->find($location);
            return $this->measurementRepository->findByLocation($location);
        }
        else
            return $this->measurementRepository->findByLocation($location);
    }
}
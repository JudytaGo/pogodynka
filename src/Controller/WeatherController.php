<?php // src/Controller/WeatherController.php
namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function cityAndCountryAction(string $country, string $city, WeatherUtil $util): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        return $this->render('weather/countrycity.html.twig', [
            'country' => $country,
            'city' => $city,
            'measurements' => $measurements,
        ]);
    }

    public function cityAction(Location $city,WeatherUtil $util): Response
    {
        $measurements = $util->getWeatherForLocation($city);

        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $measurements,
        ]);
    }
}
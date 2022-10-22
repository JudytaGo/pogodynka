<?php // src/Controller/WeatherController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherController extends AbstractController
{
    public function cityAction(string $country,string $city,LocationRepository $locationRepository, MeasurementRepository $measurementRepository): Response
    {   
        $location = $locationRepository->findOneBySomeField($country,$city);
        if($location != NULL){
            $measurements = $measurementRepository->findByLocation($location);
            return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,]);
        }else{
            return $this->render('weather/homepage.html.twig');
        }

    }
    public function homePage(): Response
    {   
         return $this->render('weather/homepage.html.twig');
    }
}
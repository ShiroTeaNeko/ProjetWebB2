<?php
namespace App\Controller;

use App\Repository\RepasRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RestaurantRepository $repository
     * @return Response
     */
    public function index(RestaurantRepository $repository):Response
    {
        $restaurants = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'restaurants' => $restaurants
        ]);
    }
}

<?php
namespace App\Controller;

use App\Entity\Repas;
use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepasController extends AbstractController {

    /**
     * @var RestaurantRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(RestaurantRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/restaurants", name="restaurant.index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'current_page' => 'restaurants'
        ]);
    }

    /**
     * @Route("/restaurants/repas/{slug}-{id}", name="repas.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param string $slug
     * @param Repas $repas
     * @return Response
     */
    public function show(Repas $repas, string $slug): Response
    {
        if ($repas->getSlug() !== $slug) {
            return $this->redirectToRoute('repas.show', [
                'id' => $repas->getId(),
                'slug' => $repas->getSlug()
            ], 301);
        }
        return $this->render('repas/show.html.twig', [
            'repas' => $repas,
            'current_page' => 'allRepas'
        ]);
    }
}
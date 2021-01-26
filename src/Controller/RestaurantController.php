<?php
namespace App\Controller;

use App\Entity\Repas;
use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Form\RestaurantSearchType;
use App\Repository\RepasRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController {

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
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new RestaurantSearch();
        $form = $this->createForm(RestaurantSearchType::class, $search);
        $form->handleRequest($request);
        $restaurants = $paginator->paginate(
            $this->repository->findAllVisible($search),
            $request->query->getInt('page',1),
            12
        );
        return $this->render('restaurant/index.html.twig', [
            'current_page' => 'restaurants',
            'restaurants' => $restaurants,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/restaurants/{slug}-{id}", name="restaurant.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Restaurant $restaurant
     * @param Repas $repas
     * @param string $slug
     * @return Response
     */
    public function show(Restaurant $restaurant,RepasRepository $repository, string $slug): Response
    {
        if ($restaurant->getSlug() !== $slug) {
            return $this->redirectToRoute('restaurant.show', [
                'id' => $restaurant->getId(),
                'slug' => $restaurant->getSlug()
            ], 301);
        }
        $repas = $repository->findLatest();
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            'allRepas' => $repas,
            'current_page' => 'restaurant'
        ]);
    }


}
<?php
namespace App\Controller\Admin;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RepasRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRestaurantController extends AbstractController{

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
     * @Route("/admin", name="admin.restaurant.index")
     * @return Response
     */
    public function index()
    {
        $restaurants = $this->repository->findAll();
        return $this->render('admin/restaurant/index.html.twig', compact('restaurants'));
    }

    /**
     * @Route("/admin/restaurant/create", name="admin.restaurant.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($restaurant);
            $this->em->flush();
            $this->addFlash('success', 'Le restaurant a été ajouté!');
            return $this->redirectToRoute('admin.restaurant.index');
        }

        return $this->render('admin/restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/restaurant/{id}", name="admin.restaurant.edit", methods="GET|POST")
     * @param Restaurant $restaurant
     * @return Response
     */
    public function edit(Restaurant $restaurant, Request $request)
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modification enregistré!');
            return $this->redirectToRoute('admin.restaurant.index');
        }

        return $this->render('admin/restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/restaurant/{id}", name="admin.restaurant.delete", methods="DELETE")
     * @param Restaurant $restaurant
     */
    public function delete(Restaurant $restaurant, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->get('_token')))
        {
            $this->em->remove($restaurant);
            $this->em->flush();
            $this->addFlash('success', 'Suppression confirmé!');
        }
        return $this->redirectToRoute('admin.restaurant.index');
    }
}
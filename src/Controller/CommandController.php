<?php
namespace App\Controller;

use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController {

    /**
     * @Route("/command", name="command_index")
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session, RepasRepository $repasRepository)
    {
        $command = $session->get('command', []);

        $commandWithData = [];

        foreach ($command as $id => $quantity) {
            $commandWithData[] = [
                'product' => $repasRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($commandWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('command/index.html.twig', [
            'items' => $commandWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/command/add/{id}", name="command_add")
     * @param $id
     * @param SessionInterface $session
     */
    public function add($id, SessionInterface $session)
    {
        $command = $session->get('command', []);

        if (!empty($command[$id])) {
            $command[$id]++;
        } else {
            $command[$id] = 1;
        }

        $session->set('command',$command);

        return $this->redirectToRoute("command_index");
    }

    /**
     * @Route("/command/remove/{id}", name="command_remove")
     */
    public function remove($id, SessionInterface $session)
    {
        $command = $session->get('command', []);

        if (!empty($command[$id]))
        {
            unset($command[$id]);
        }

        $session->set('command', $command);

        return $this->redirectToRoute("command_index");
    }
}
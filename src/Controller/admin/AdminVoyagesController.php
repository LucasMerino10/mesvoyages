<?php

namespace App\Controller\admin;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminVoyagesController
 *
 * @author Lucas
 */
class AdminVoyagesController extends AbstractController {
    /**
     * 
     * @var VisiteRepository
     */
    private $repository;
    /**
     * @Route("/admin", name="admin.voyages")
     * @return Response
     */
    public function index(): Response{
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("admin/admin.voyages.html.twig", [
            'visites' => $visites
        ]);
    }
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository){
        $this ->repository = $repository;
    }
    /**
     * @Route("/admin/suppr/{id}", name="admin.voyage.suppr")
     * @param Visite $visite
     * @return Response
     */
    public function suppr(Visite $visite): Response{
        $this->repository->remove($visite, true);
        return $this->redirectToRoute('admin.voyages');
    }
}

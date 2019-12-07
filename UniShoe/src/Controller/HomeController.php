<?php


namespace App\Controller;


use App\Repository\ShoeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ShoeRepository $repository
     * @return Response
     */
    public function index(ShoeRepository $repository): Response
    {
        $articles = $repository->findLatest();
        return $this->render('web/home.html.twig', [
            'articles' => $articles
        ]);
    }
}
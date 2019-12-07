<?php


namespace App\Controller\EditSoldShoe;


use App\Entity\Shoe;
use App\Entity\User;
use App\Form\ShoeEditType;
use App\Repository\ShoeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ManageShoeController extends AbstractController
{
    /**
     * @var ShoeRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ShoeRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->em = $entityManager;
    }

    /**
     * @Route("/chaussures/vente", name="sold")
     * @param Security $security
     * @return Response
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        $articles = $this->repository->findSoldUser($user->getId());
        return $this->render('web/sold.html.twig', compact('articles'));
    }

    /**
     * @Route("/chaussures/vente/creer", name="article.create")
     * @param Request $request
     * @param Security $security
     * @return Response
     */
    public function createArticles(Request $request, Security $security)
    {
        $user = $security->getUser();
        $idUser = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
        $label_User = $user->getUsername();

        $article = new Shoe();
        $article->setStock(1);
        $article->setIdUser($idUser);
        $article->setLabelUser($label_User);

        $form = $this->createForm(ShoeEditType::class, $article);
        $form->handleRequest($request);     // Permet de gérer la requête : Il va utiliser en background les setters de l'entité "Shoe" pour définir les champs qui ont été soumis dans le formulaire (et ainsi faire les modifs dans la BDD)

        if($form->isSubmitted() && $form->isValid()) {
            //$brochureFile = $form['ImageFile']->getData();

            $this->em->persist($article);
            $this->em->flush();
            $this->addFlash('success','Votre produit a correctement été créé');
            return $this->redirectToRoute('sold');
        }

        return $this->render('web/create.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/chaussures/vente/editer/{id}", name="article.edit")
     * @param Shoe $article
     * @param Request $request
     * @return Response
     */
    public function editArticles(Shoe $article, Request $request): Response
    {
        $form = $this->createForm(ShoeEditType::class, $article);
        $form->handleRequest($request);     // Permet de gérer la requête : Il va utiliser en background les setters de l'entité "Shoe" pour définir les champs qui ont été soumis dans le formulaire (et ainsi faire les modifs dans la BDD)

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Votre produit a correctement été modifié avec succès');
            return $this->redirectToRoute('sold');
        }

        return $this->render('web/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/chaussures/vente/delete/{id}", name="article.delete")
     * @param Shoe $article
     * @return Response
     */
    public function deleteArticles(Shoe $article): Response
    {
        $this->em->remove($article);
        $this->em->flush($article);
        $this->addFlash('success','Votre produit a correctement été supprimé de la liste des ventes.');
        return $this->redirectToRoute('sold');
    }
}
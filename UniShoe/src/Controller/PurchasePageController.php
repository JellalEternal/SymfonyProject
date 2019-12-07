<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Shoe;
use App\Entity\User;
use App\Form\ContactFormType;
use App\Repository\ShoeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class PurchasePageController extends AbstractController
{
    /**
     * @var ShoeRepository
     */
    private $repository;

    public function __construct(ShoeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/chaussures", name="purchase")
     * @param Security $security
     * @return Response
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        $articles = $this->repository->findPurchaseShoe($user->getId());
        return $this->render('web/purchase.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/chaussures/detail/{slug}-{id}", name="article.detail", requirements={"slug":"[a-z0-9\-]*"})
     * @param Shoe $article
     * @param string $slug
     * @return Response
     */
    public function show(Shoe $article, string $slug): Response
    {
        $contact = new Contact();
        $contact->setArticle($article);
        $form = $this->createForm(ContactFormType::class, $contact);
        if($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.detail',[
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ],301);
        }

        return $this->render('web/detail.html.twig',[
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
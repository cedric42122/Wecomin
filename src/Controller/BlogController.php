<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(AuthorizationCheckerInterface $authChecker , Article $article = null, Request $request, ObjectManager $manager)
    {
        // Restriction de l'acces a l'Admin
        if(!$authChecker->isGranted('ROLE_ADMIN')) 
        {
            return $this->redirectToRoute('home');
        }

        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreateAt(new \DateTime());J
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute(
                'blog_show',
                [
                    'id' => $article->getId()
                ]
            );
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}

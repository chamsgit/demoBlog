<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * methode permettant d'afficher l'ensemble des artciles du blog
     * @Route("/blog", name="blog")
     */
    public function blog(ArticleRepository $repoArticles): Response
    {
      // Pour selectionner des données dans une table SQL en BDD? nous devons importer la classe Repository qui correspond à la table SQL, c'est à dire à l'entité correspondante (Article)
        // Une classe Repository permet uniquement de formuler et d'executer des requetes SQL de selection (SELECT)
        // Cette classe contient des méthodes mis à disposition par Symfony pour formuler et executer des requetes SQL en BDD

        // $repoArticles= $this->getDoctrine()->getRepository(Article::class);
        dump($repoArticles);

        $articles = $repoArticles->findAll();
        dump($articles);

        return $this->render('blog/blog.html.twig', [
            'articlesBDD' => $articles
        ]);
    }


      /**
     * @route("blog/new", name="blog_create")
     * methode pour créer un nouvel article ou faire une modification 
     */
    public function create(): Response
    {
        return $this->render('blog/create.html.twig');
    }

    /**
     * @route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article): Response
     {
        //  dump($id);

        //  $repoArticle = $this->getDoctrine()->getRepository(Article::class);
        //  dump($repoArticle);


         // find() : méthode mise à dispostion par Symfony issue de la classe ArticleRepository permettant de selectionner un élément de la BDD par son ID 
        // $article : tableau ARRAY contenant toutes les données de l'article selectionné en BDD en fonction de l'ID transmit dans l'URL

         // SELECT * FROM article WHERE id = 6 + FETCH
        // $article = $repoArticle->find($id);
         dump($article);

         return $this->render('blog/show.html.twig',['articleBDD' => $article]);

     }



     
  

    /**
     * @Route("/", name="home")
     */

     public function home(): Response
     {
        return $this->render('blog/home.html.twig',[
            'title' => 'Blog musical à voir absolument!!!',
            'age'  => 25
        ]);
     }

}


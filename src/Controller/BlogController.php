<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * methode permettant d'afficher l'ensemble des artciles du blog
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {

        $repoArticles= $this->getDoctrine()->getRepository(Article::class);
        dump($repoArticles);
        
        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @route("/blog/12", name="blog_show")
     */
    public function show(): Response
     {
         return $this->render('blog/show.html.twig');
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

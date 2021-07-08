<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BlogController extends AbstractController
{
    /**
     * methode permettant d'afficher l'ensemble des artciles du blog
     * @Route("/blog", name="blog")
     * 
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
     * @route("blog/new_old", name="blog_create_old")
     * methode pour créer un nouvel article ou faire une modification 
     */

    public function createOld(Request $request, EntityManagerInterface $manager): Response
    {
        dump($request);
       // La classe Request permet de stocker et d'avoir accès aux données véhiculées par les superglobales ($_POST, $_GET, $_COOKIE, $_FILES etc...)
         
             // Si nous vouclons insérer des données dans la table SQL Article, nous devons instancier et remplir un objert issu de son entité correspondante (classe Article)
       if($request->request->count() > 0)
       {
           $article = new Article;
           $article->setTitre($request->request->get('titre'))
                ->setContenu($request->request->get('contenu'))
                ->setImage($request->request->get('image'))
                ->setDate(new \DateTime());
                 dump($article);

                 $manager->persist($article);

                 $manager->flush();

                  // Après l'insertion de l'article en BDD, nous redirigeons l'internaute vers le'affichage du détail de l'article, donc une autre route via la méthode redirectToRoute()
            // Cette méthode attend 2 arguments 
            // 1. La route 
            // 2. le paramètre a transmettre dans la route, dans notre cas l'ID de l'article

                 return $this->redirectToRoute('blog_show', [ 
                       'id' => $article->getId()
                       ]);
       }

       return $this->render('blog/create.html.twig');


      
    }

      /**
     * @route("blog/new", name="blog_create_new")
     * @route("/blog/{id}/edit", name="blog_edit")
     */
    public function create(Article $article = null, Request $request, EntityManagerInterface $manager): Response

    // Si la variable $article N'EST PAS (null), si elle ne contient aucun article de la BDD, cela veut dire nous avons envoyé la route '/blog/new', c'est une insertion, on entre dans le IF et on crée une nouvelle instance de l'entité Article, création d'un nouvel article
        // Si la variable $article contient un article de la BDD, cela veut dire que nous avons envoyé la route '/blog/id/edit', c'est une modifiction d'article, on entre pas dans le IF, $article ne sera pas null, il contient un article de la BDD, l'article à modifier

    {
       if(!$article)
       {
          $article = new Article;
       }
      
         
        // en renseignent les setteurs de l'entité, les valeurs sont directement envoyé dans le formulaire
        // $article->setTitre("Titre bidon")
        //          ->setContenu("contenu bidon");

        dump($request);

        // createForm() permet de créer le formulaire avec la classe articleType
        $formArticle = $this->createform(ArticleType::class, $article);
         
        // handleRequest() permet ici dans notre cas, de récupérer toute les données saisie dans le formulaire et de les transmettre aux bon setteurs de l'entité $article 
        // handleRequest() renseigne chaque setteur de l'entité $article avec les données saisi dans le formulaire
        $formArticle->handleRequest($request);

            // Si le formulaire a bien été validé && que toute les données saisie sont bien transmise à la bonne entité, alors on entre dans la condition IF
        if($formArticle->isSubmitted() && $formArticle->isValid())
        {
            // on ajoute la date car pas de champs date dans le formulaire

            if(!$article->getId())
            {
                $article->setDate(new \DateTime());
            }
            

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [ 
                'id' => $article->getId()
                ]);
        }


        return $this->render('blog/create2.html.twig', [
            'formArticle' => $formArticle->createView(),
            // on transmet le formulaire au template afin de pouvoir l'afficher avec Twig 
            // createView() va retourner un petit objet qui représente l'affichage du formulaire, on le récupère dans le template create2.html.twig
           
            'editMode' => $article->getId()  //on transmet l'id dans l'article au template
        ]);
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


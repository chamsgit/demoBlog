<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $faker = \Faker\Factory::create('fr_FR');
            //creation de 3 catégory
     for($cat =1; $cat <=3; $cat++)
     {
         $category = new Category;

         $category->setTitre($faker->word)

         ->setDescription($faker->paragraph());

         $manager->persist($category);

         // creation de 4 à 10 articles
         for($cat =1; $cat <=mt_rand(4,10); $cat++)
     {
         $contenu ='<p>' .join($faker->paragraphs(5), '</p><p>') . '</p>';
         $article = new Article;
         $article->setTitre($faker->sentence())
                 ->setContenu($contenu)
                 ->setImage($faker->ImageUrl(600,600))
                 ->setDate($faker->dateTimeBetween('-6 months'))
                 ->setCategory($category);

         $manager->persist($article);

         //creation 4 à 10 commentaires
         for($cmt = 1; $cmt <= mt_rand(4,10); $cmt++)
         {
            

             $now = new DateTime;
             $interval = $now->diff($article->getDate());
             $days = $interval->days;
             $minimum ="-$days days";

             $contenu ='<p>' .join($faker->paragraphs(2), '</p><p>') . '</p>';

             $commentaire = new Commentaire;

             $commentaire->setAuteur($faker->name)
                          ->setMessageCommentaire($contenu)
                          ->setDate($faker->dateTimeBetween($minimum))
                          ->setArticle($article);
            
            $manager->persist($commentaire);
         }
         

     }

    }

    $manager->flush();
 }
}

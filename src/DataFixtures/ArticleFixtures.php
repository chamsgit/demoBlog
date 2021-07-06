<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            //la boucle for tourne 10 fois pour créer 10 articles
            for($i = 1; $i <=11; $i++)
            {
                $article = new Article;

                $article->setTitre("titre de l'article $i")
                        ->setContenu( "<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt adipisci rem omnis repellat deleniti labore culpa excepturi rerum hic! Illum!lorem50 picsum10 Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta voluptate, consectetur ratione, suscipit facilis numquam nostrum explicabo possimus architecto labore hic, rerum aspernatur vitae quibusdam odit magni? Tempore quia earum vel, adipisci officia nulla non commodi quis assumenda perspiciatis laboriosam quas consectetur, ea labore incidunt, facilis perferendis eum iure eligendi. </p>"
                          )
                          ->setImage("https://picsum.photos/seed/picsum/200/300")
                          ->setDate(new \DateTime());


                $manager->persist($article);

            }
    

        $manager->flush();
    }
}

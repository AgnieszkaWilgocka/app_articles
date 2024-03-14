<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 10, function(Article $article) use ($manager){
            $article->setTitle($this->faker->colorName());
            $article->setText($this->faker->sentence(3, 10));
            $article->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-7 days', 'now')));
            $authors = $this->getRandomReferences(Author::class, $this->faker->numberBetween(1, 2));

            foreach($authors as $author) {
                $article->addAuthor($author);
            }
            $manager->persist($article);

        });
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [AuthorFixtures::class];
    }
}
?>
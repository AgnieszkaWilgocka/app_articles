<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends AbstractBaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Author::class, 10, function(Author $author) use ($manager) {
            $author->setName($this->faker->sentence(1));
            $manager->persist($author);
        }
    );
    $manager->flush();
    }  
}

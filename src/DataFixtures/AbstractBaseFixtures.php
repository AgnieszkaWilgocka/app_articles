<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

abstract class AbstractBaseFixtures extends Fixture
{


    protected Generator $faker;

    private ObjectManager $manager;

    private array $referencesIndex = [];


    abstract protected function loadData(ObjectManager $manager) : void;


    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;
        $this->loadData($manager);
    }


    protected function createMany(string $className, int $count, callable $factory): void
    {
        for($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            $this->addReference($className . '_' . $i, $entity);
        }
    }

    protected function getRandomReference(string $className) : object {
        if(!isset($this->referencesIndex[$className])) {
            $referencesIndex[$className] = [];
        }
        
        foreach(array_keys($this->referenceRepository->getReferences()) as $key) {
            if(str_starts_with((string) $key, $className . '_')) {
                $this->referencesIndex[$className][] = $key;
            }
        }

        if(empty($this->referencesIndex[$className])) {
            throw new \InvalidArgumentException(sprintf('Cannot find any references  with "%s"' , $className));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);

        return $this->getReference($randomReferenceKey);
    }
    
    protected function getRandomReferences(string $className, int $count): array
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($className);
        }

        return $references;
    }
}
?>
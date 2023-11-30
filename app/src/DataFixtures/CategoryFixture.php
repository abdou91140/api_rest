<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Emploi', 'Immobilier', 'Automobile'];

        foreach ($categories as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference($name,$category); // Define references

        }

        $manager->flush();
    }
}

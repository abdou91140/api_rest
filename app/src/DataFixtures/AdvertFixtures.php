<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Advert;
use App\DataFixtures\CategoryFixture;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $category = $this->getReference('Automobile');
            $advert = new Advert();
            $advert->setTitle('Your Advert Title');
            $advert->setContent(' Your content');
            $advert->setCategory($category);
            $manager->persist($advert);
            $manager->flush();
        }

    }

    public function getDependencies()
    {
        return [
            CategoryFixture::class,
        ];
    }
}

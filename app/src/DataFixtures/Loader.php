<?php

namespace App\DataFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Loader extends Fixture implements DependentFixtureInterfaceclass
{ 
   public function load(ObjectManager $manager)
    {
    // Add the CategoryFixtures first
    $this->addReference('categories', $this->getReference('categories'));
    $this->addReference('advert', $this->getReference('advert'));

    // Add other fixtures in the desired order
    // $this->addFixture(new OtherFixtures());
}
public function getDependencies()
    {
        return [
            CategoryFixture::class,          
            CarBrandFixtures::class,
            AdvertFixtures::class
        ];
    }
}
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\CarBrand;
use App\Entity\CardBrand;
use App\Entity\CardModel;
use App\Entity\CarModel;

class CarBrandFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $brandsData = [
            'Audi' => ['Cabriolet', 'Q2', 'Q3', 'Q5', 'Q7', 'Q8', 'R8', 'Rs3', 'Rs4', 'Rs5', 'Rs7', 'S3', 'S4', 'S4 Avant', 'S4 Cabriolet', 'S5', 'S7', 'S8', 'SQ5', 'SQ7', 'Tt', 'Tts', 'V8'],
            'BMW' => ['M3', 'M4', 'M5', 'M535', 'M6', 'M635', 'Serie 1', 'Serie 2', 'Serie 3', 'Serie 4', 'Serie 5', 'Serie 6', 'Serie 7', 'Serie 8'],
            'Citroen' => ['C1', 'C15', 'C2', 'C25', 'C25D', 'C25E', 'C25TD', 'C3', 'C3 Aircross', 'C3 Picasso', 'C4', 'C4 Picasso', 'C5', 'C6', 'C8', 'Ds3', 'Ds4', 'Ds5'],
        ];

        foreach ($brandsData as $brandName => $models) {
            $brand = new CardBrand;
            $brand->setName($brandName);


            foreach ($models as $modelName) {
                $model = new CardModel();
                $model->setName($modelName);
                $model->setBrand($brand); 
                $manager->persist($model);
            }
            
            $manager->persist($brand); 
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Banner;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category
            ->setImage('image1')
            ->setTitle('category1')
            ->setDescription('hello world')
            ->setPosition(1)
        ;

        $banner = new Banner();
        $banner
            ->setTitle('hello')
            ->setDescription('this is it')
            ->setBackgroundImage('image')
        ;

        for ($i=0; $i < 30; $i++) { 
            $product = new Product();
            $product
                ->setImage("image$i")
                ->setTitle("product$i")
                ->setDescription("This is my product$i")
                ->setPrice(rand(10, 200))
                ->addCategory($category)
                ->setBanner($banner)
            ;
            $manager->persist($product);
        }

        $manager->persist($banner);
        $manager->flush();
    }
}

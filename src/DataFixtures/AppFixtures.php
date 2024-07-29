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

        $product1 = new Product();
        $product1
            ->setImage('image')
            ->setTitle('product1')
            ->setDescription('hello world')
            ->setPrice(100)
            ->setPosition(1)
            ->addCategory($category)
        ;

        $banner = new Banner();
        $banner
            ->setTitle('hello')
            ->setDescription('this is it')
            ->setBackgroundImage('image')
            ->addProduct($product1)
        ;

        $manager->persist($banner);
        $manager->flush();
    }
}

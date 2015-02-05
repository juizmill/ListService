<?php

namespace Application\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Entity\Category;

class CategoryLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     * @param  \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $category = new Category;
        $category->setDescription('Development')->setActive(true);
        $manager->persist($category);

        $category1 = new Category;
        $category1->setDescription('Banner')->setActive(true);
        $manager->persist($category1);

        $category2 = new Category;
        $category2->setDescription('Financial')->setActive(true);
        $manager->persist($category2);

        $manager->flush();
    }
    /**
    * @return int
    */
    public function getOrder()
    {
        return 1;
    }
}

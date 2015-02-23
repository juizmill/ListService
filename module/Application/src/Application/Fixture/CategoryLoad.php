<?php

namespace Application\Fixture;

use Application\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoryLoad
 *
 * @package Application\Fixture
 */
class CategoryLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Category load
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
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

        $this->setReference('category1', $category);
        $this->setReference('category2', $category1);
        $this->setReference('category3', $category2);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}

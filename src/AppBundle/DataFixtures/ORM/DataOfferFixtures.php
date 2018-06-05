<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DataOfferFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $offer = new Offer();
        $offer
            ->setPrice(0)
            ->setQuota(30 * 1000);

        $manager->persist($offer);

        $offer = new Offer();
        $offer
            ->setPrice(1)
            ->setQuota(100 * 1000);

        $offer = new Offer();
        $offer
            ->setPrice(1.99)
            ->setQuota(200 * 1000);

        $manager->persist($offer);

        $offer = new Offer();
        $offer
            ->setPrice(6)
            ->setQuota(1 * 1000 * 1000);

        $manager->persist($offer);

        $offer = new Offer();
        $offer
            ->setPrice(9.99)
            ->setQuota(2 * 1000 * 1000);

        $manager->persist($offer);

        $offer = new Offer();
        $offer
            ->setPrice(19.99)
            ->setQuota(5 * 1000 * 1000);

        $manager->persist($offer);

        $offer = new Offer();
        $offer
            ->setPrice(37.99)
            ->setQuota(10 * 1000 * 1000);

        $manager->persist($offer);

        $manager->flush();
    }

    public function getOrder()
    {
        return 0;
    }
}

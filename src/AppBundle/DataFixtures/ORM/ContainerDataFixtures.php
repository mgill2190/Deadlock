<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Container;
use AppBundle\Entity\Shipment;
use AppBundle\Entity\Transport;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ContainerDataFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        foreach (['EXP17003955'] as $reference) {
            $shipment = new Shipment();
            $shipment->setReference($reference);
            $manager->persist($shipment);
            $manager->flush();
        }

        foreach (['MRKU0429690', 'CAXU7420415'] as $containerNo) {
            $container = new Container();
            $container->setContainerNo($containerNo);
            $manager->persist($container);

            $transport = new Transport();
            $transport->setContainer($container);
            $transport->setTypeId('DEL');
            $transport->setTransportDate(new \DateTime());
            $transport->setShipment($shipment);
            $manager->persist($transport);

            $manager->flush();
        }
    }
}

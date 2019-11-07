<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="transport")
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $type_id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $transport_date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shipment", inversedBy="transport")
     * @ORM\JoinColumn(name="shipment_id", referencedColumnName="id", nullable=false)
     */
    private $shipment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Container", inversedBy="transport", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="container_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $container;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param string $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return string
     */
    public function getTransportDate()
    {
        return $this->transport_date;
    }

    /**
     * @param string $transport_date
     */
    public function setTransportDate($transport_date)
    {
        $this->transport_date = $transport_date;
    }

    /**
     * @return mixed
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @param mixed $shipment
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }
}

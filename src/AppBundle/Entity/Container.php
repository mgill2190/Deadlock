<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="container")
 */
class Container
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $container_no;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transport", mappedBy="container", cascade={"persist", "remove"})
     */
    private $transport;

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
    public function getContainerNo()
    {
        return $this->container_no;
    }

    /**
     * @param string $container_no
     */
    public function setContainerNo($container_no)
    {
        $this->container_no = $container_no;
    }

    /**
     * @return mixed
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }


}
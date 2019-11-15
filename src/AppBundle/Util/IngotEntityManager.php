<?php
namespace AppBundle\Util;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Exception\DriverException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;

class IngotEntityManager extends EntityManagerDecorator
{
    private $em;
    private $mr;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $managerRegistry)
    {
        parent::__construct($entityManager);
        $this->em = $entityManager;
        $this->mr = $managerRegistry;
    }

    /**
     * Override flush method to prevent deadlock issues. If flush fails, retry ten times.
     *
     * @param null $entity
     * @throws \Exception
     */
    /**
     * Override flush method to prevent deadlock issues. If flush fails, retry ten times.
     *
     * @param null $entity
     * @throws \Exception
     */
    public function flush($entity = null)
    {
        $retry = 0;
        $maxRetry = 10;
        while (++$retry <= $maxRetry) {
            try {
                echo "attempting to flush\n";
                $this->em->flush();
            } catch (DriverException $e) {
                echo "failed on attempt " . $retry . " with error code " . $e->getErrorCode() . "\n";
                if ($e->getErrorCode() === 1213) {
                    if ($retry === $maxRetry) {
                        echo "max retries reached\n";
                        throw  $e;
                    }
                    $this->rollback();
                    $this->close();
                    $this->resetManager();
                    sleep(0.1);
                    continue;
                }
                throw $e;
            }

            //break out of while loop if no error caught
            echo "flush worked successfully\n";
            break;
        }
    }

    public function resetManager()
    {
        $this->em = $this->mr->resetManager();
    }
}
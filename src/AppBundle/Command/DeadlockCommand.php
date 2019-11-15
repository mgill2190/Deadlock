<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeadlockCommand extends ContainerAwareCommand
{
    private $entityManager;
    private $transportRepository;

    public function configure()
    {
        $this
            ->setName('deadlock')
            ->addArgument('process', InputArgument::REQUIRED, '1|2')
        ;
    }

    // Todo: inject to constructor
    private function initializeDependencies()
    {
        $container = $this->getContainer();
        //$this->entityManager = $container->get('doctrine.orm.default_entity_manager');
        $this->entityManager = $container->get('deadlock.util.ingot_entity_manager');
        $this->transportRepository = $this->entityManager->getRepository('AppBundle:Transport');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initializeDependencies();

        $transport1 = $this->getTransportByContainerQuery('CAXU7420415');
        $transport2 = $this->getTransportByContainerQuery('MRKU0429690');

        $entityManager = $this->entityManager;

        if ($input->getArgument('process') === '1') {
            //use connection->transaction as it doesnt close the em on error.
            $this->entityManager->getConnection()->transactional(
                function () use ($entityManager, $transport1, $transport2, $output) {
                    $this->entityManager->getConnection()->setAutoCommit(false);
                    $transport1->setTransportDate(new \DateTime());
                    $output->writeln('CAXU7420415 locked');
                    $entityManager->persist($transport1);
                    $entityManager->flush();
                    sleep(5);
                    $transport2->setTransportDate(new \DateTime());
                    $output->writeln('Trying to lock MRKU0429690');
                    $entityManager->persist($transport1);
                    $entityManager->flush();

                }
            );
        } else {
            //use connection->transaction as it doesnt close the em on error.
            $this->entityManager->getConnection()->transactional(
                function () use ($entityManager, $transport1, $transport2, $output) {
                    $transport2->setTransportDate(new \DateTime());
                    $output->writeln('CAXU7420415 locked');
                    $entityManager->persist($transport2);
                    $entityManager->flush();
                    $transport1->setTransportDate(new \DateTime());
                    $output->writeln('MRKU0429690 locked');
                    $entityManager->persist($transport1);
                    $entityManager->flush();
                }
            );
        }
    }

    /**
     * @param $containerNo
     * @return mixed
     */
    private function getTransportByContainerQuery($containerNo) {

        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('t')
            ->from('AppBundle:Transport', 't')
            ->join('t.container', 'c')
            ->where('c.container_no = :containerNo')
            ->setParameter('containerNo', $containerNo);

        return $qb->getQuery()->getResult()[0];
    }
}


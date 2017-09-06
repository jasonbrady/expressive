<?php

namespace App\Command;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager, $name = null)
    {
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

    /**
     * Configures the command
     */
    protected function configure()
    {
        $this->setName('hello')
            ->setDescription('Says hello')
        ;
    }

    /**
     * Executes the current command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello World!");

        // Do something with the entityManager
        $logger = new Logger('collect-product-data');
        $logger->pushHandler(new \Symfony\Bridge\Monolog\Handler\ConsoleHandler($output));
        $logger->debug('Log something');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: jason brady
 * Date: 9/5/2017
 * Time: 2:00 PM
 */

namespace App\Command;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends Command
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager, $name = null)
    {
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }//end __construct()

    protected function configure()
    {
        $this->setName('hello')
            ->setDescription('Says Hello');
    }//end configure()

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new Logger('collect-product-data');
        $logger->pushHandler(new ConsoleHandler($output));
        $logger->debug('Log Something');

        $output->writeln("Hello World!");
    }//end execute()
}
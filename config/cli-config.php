<?php
/**
 * Created by PhpStorm.
 * User: jason brady
 * Date: 9/5/2017
 * Time: 7:46 AM
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean
 */
return call_user_func(function() {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    $entityManager = $container->get(\Doctrine\ORM\EntityManager::class);
    return ConsoleRunner::createHelperSet($entityManager);
});
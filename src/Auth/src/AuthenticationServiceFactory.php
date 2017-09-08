<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/6/2017
 * Time: 6:08 PM
 */

namespace Auth;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticationServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationService(
            null,
            $container->get(MyAuthAdapter::class)
        );
    }
}
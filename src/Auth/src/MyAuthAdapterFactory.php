<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/5/2017
 * Time: 9:32 PM
 */

namespace Auth;


use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;

class MyAuthAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MyAuthAdapter();
    }
}
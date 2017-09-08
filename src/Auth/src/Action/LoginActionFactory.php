<?php
/**
 * Created by PhpStorm.
 * User: jason brady
 * Date: 9/8/2017
 * Time: 11:46 AM
 */

namespace Auth\Action;


use Auth\MyAuthAdapter;
use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(AuthenticationService::class),
            $container->get(MyAuthAdapter::class)
        );
    }//end __invoke()
}
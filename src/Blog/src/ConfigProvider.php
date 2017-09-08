<?php

namespace Blog;

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Zend\Expressive\Application;
use Blog\Factory\RoutesDelegator;

/**
 * The configuration provider for the Blog module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrine(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'invokables' => [
            ],
            'factories'  => [
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDoctrine(): array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'drivers' => [
                        'Blog\Entity' => 'blog_entity',
                    ],
                ],
                'blog_entity' => [
                    'class' => SimplifiedYamlDriver::class,
                    'cache' => 'array',
                    'paths' => [
                        dirname(__DIR__) . '/config/doctrine' => 'Blog\Entity',
                    ],
                ],
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'blog'    => [__DIR__ . '/../templates/blog'],
            ],
        ];
    }
}

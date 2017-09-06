<?php
/**
 * Created by PhpStorm.
 * User: jason brady
 * Date: 9/5/2017
 * Time: 8:00 AM
 */

return [
    'doctrine' => [
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [],
            ]
        ]
    ]
];
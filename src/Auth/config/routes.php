<?php
/**
 * Created by PhpStorm.
 * User: jason brady
 * Date: 9/8/2017
 * Time: 12:04 PM
 */

use Auth\Action\LoginAction;

$app->route('/login', LoginAction::class, ['GET', 'POST'], 'login');

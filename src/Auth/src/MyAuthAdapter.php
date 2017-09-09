<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/5/2017
 * Time: 9:26 PM
 */

namespace Auth;


use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class MyAuthAdapter implements AdapterInterface
{
    private $password;
    private $username;

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    public function authenticate()
    {
        $row = [
            'username' => 'test',
            'password' => password_hash('test', PASSWORD_DEFAULT),
        ];

        if(password_verify($this->password, $row['password'])) {
            return new Result(Result::SUCCESS, $row);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }
}
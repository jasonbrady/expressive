<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/6/2017
 * Time: 6:24 PM
 */

namespace Auth\Action;


use Auth\MyAuthAdapter;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginAction implements ServerMiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $template;
    /**
     * @var AuthenticationService
     */
    private $auth;
    /**
     * @var MyAuthAdapter
     */
    private $authAdapter;

    public function __construct(
        TemplateRendererInterface $template,
        AuthenticationService $auth,
        MyAuthAdapter $authAdapter
    )
    {
        $this->template = $template;
        $this->auth = $auth;
        $this->authAdapter = $authAdapter;
    }


    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if($request->getMethod() === 'POST') {
            return $this->authenticate($request);
        }

        return new HtmlResponse($this->template->render('auth::login'));
    }


    public function authenticate(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();

        if(empty($params['username'])) {
            return new HtmlResponse($this->template->render('auth::login'), [
                'error' => 'The username cannot be empty',
            ]);
        }

        if(empty($params['password'])) {
            return new HtmlResponse($this->template->render('auth::login'), [
                'username' => $params['username'],
                'error' => 'The password cannot be empty',
            ]);
        }

        $this
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/5/2017
 * Time: 7:45 PM
 */

namespace Blog\Action;


use Blog\Entity\BlogPost;
use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class BlogPostViewAction implements MiddlewareInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    public function __construct(
        EntityManager $entityManager,
        RouterInterface $router,
        TemplateRendererInterface $templateRenderer = null
    ) {

        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->templateRenderer = $templateRenderer;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /** @var RouteResult $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);
        $routeMatchedParams = $routeResult->getMatchedParams();
        if(empty($routeMatchedParams['blog_post_id'])) {
            throw new \RuntimeException('Invalid Route: "blog_post_id" not set in matched route params.');
        }
        $blogId = $routeMatchedParams['blog_post_id'];

        $blogPost = $this->entityManager->find(BlogPost::class, $blogId);
        if(!$blogPost) {
            return new HtmlResponse($this->templateRenderer->render('error::404'), 404);
        }

        $data = [
            'post' => $blogPost,
        ];

        return new HtmlResponse($this->templateRenderer->render('blog::view', $data));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 9/5/2017
 * Time: 7:38 PM
 */

namespace Blog\Action;

use Blog\Entity\BlogPost;
use Doctrine\ORM\EntityManager;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class BlogPostListAction implements MiddlewareInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    public function __construct(
        EntityManager $entityManager,
        TemplateRendererInterface $templateRenderer
    ) {

        $this->entityManager = $entityManager;
        $this->templateRenderer = $templateRenderer;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $posts = $this->entityManager->getRepository(BlogPost::class)->findAll();
        $data = ['posts' => $posts];

        return new HtmlResponse($this->templateRenderer->render('blog::list', $data));
    }
}
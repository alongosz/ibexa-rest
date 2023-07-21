<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Bundle\Rest\RequestParser;

use Ibexa\Contracts\Rest\Exceptions\InvalidArgumentException;
use Ibexa\Rest\RequestParser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Router based request parser.
 */
class Router implements RequestParser
{
    private RouterInterface $router;
    private KernelInterface $kernel;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(RouterInterface $router, KernelInterface $kernel, EventDispatcherInterface $eventDispatcher)
    {
        $this->router = $router;
        $this->kernel = $kernel;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function parse($url): array
    {
        // we create a request with a new context in order to match $url to a route and get its properties
        $request = Request::create($url, 'GET');

        $originalContext = $this->router->getContext();
        $context = clone $originalContext;
        $context->fromRequest($request);
        $this->router->setContext($context);

        $event = new RequestEvent($this->kernel, $request, HttpKernelInterface::MAIN_REQUEST);
        try {
            $this->eventDispatcher->dispatch($event, KernelEvents::REQUEST);
            if (false === $request->attributes->getBoolean('is_rest_request')) {
                throw new InvalidArgumentException("No route matched '$url'");
            }

            return $request->attributes->all();
        } catch (NotFoundHttpException $e) {
            throw new InvalidArgumentException("No route matched '$url'");
        } finally {
            $this->router->setContext($originalContext);
        }
    }

    public function generate($type, array $values = [])
    {
        return $this->router->generate($type, $values);
    }

    /**
     * @throws \Ibexa\Core\Base\Exceptions\InvalidArgumentException If $attribute wasn't found in the match
     */
    public function parseHref($href, $attribute)
    {
        $parsingResult = $this->parse($href);

        if (!isset($parsingResult[$attribute])) {
            throw new InvalidArgumentException("No attribute '$attribute' in route matched from $href");
        }

        return $parsingResult[$attribute];
    }
}

class_alias(Router::class, 'EzSystems\EzPlatformRestBundle\RequestParser\Router');

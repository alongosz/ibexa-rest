<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Controller;

use Ibexa\Rest\Server\Exceptions\ForbiddenException;
use eZ\Publish\API\Repository\Exceptions\InvalidArgumentException;
use Ibexa\Rest\Message;
use Ibexa\Rest\Server\Values;
use Ibexa\Rest\Server\Controller as RestController;
use eZ\Publish\API\Repository\URLWildcardService;
use Symfony\Component\HttpFoundation\Request;

/**
 * URLWildcard controller.
 */
class URLWildcard extends RestController
{
    /**
     * URLWildcard service.
     *
     * @var \eZ\Publish\API\Repository\URLWildcardService
     */
    protected $urlWildcardService;

    /**
     * Construct controller.
     *
     * @param \eZ\Publish\API\Repository\URLWildcardService $urlWildcardService
     */
    public function __construct(URLWildcardService $urlWildcardService)
    {
        $this->urlWildcardService = $urlWildcardService;
    }

    /**
     * Returns the URL wildcard with the given id.
     *
     * @param $urlWildcardId
     *
     * @return \eZ\Publish\API\Repository\Values\Content\URLWildcard
     */
    public function loadURLWildcard($urlWildcardId)
    {
        return $this->urlWildcardService->load($urlWildcardId);
    }

    /**
     * Returns the list of URL wildcards.
     *
     * @return \EzSystems\EzPlatformRest\Server\Values\URLWildcardList
     */
    public function listURLWildcards()
    {
        return new Values\URLWildcardList(
            $this->urlWildcardService->loadAll()
        );
    }

    /**
     * Creates a new URL wildcard.
     *
     * @throws \EzSystems\EzPlatformRest\Server\Exceptions\ForbiddenException
     *
     * @return \EzSystems\EzPlatformRest\Server\Values\CreatedURLWildcard
     */
    public function createURLWildcard(Request $request)
    {
        $urlWildcardCreate = $this->inputDispatcher->parse(
            new Message(
                ['Content-Type' => $request->headers->get('Content-Type')],
                $request->getContent()
            )
        );

        try {
            $createdURLWildcard = $this->urlWildcardService->create(
                $urlWildcardCreate['sourceUrl'],
                $urlWildcardCreate['destinationUrl'],
                $urlWildcardCreate['forward']
            );
        } catch (InvalidArgumentException $e) {
            throw new ForbiddenException($e->getMessage());
        }

        return new Values\CreatedURLWildcard(
            [
                'urlWildcard' => $createdURLWildcard,
            ]
        );
    }

    /**
     * The given URL wildcard is deleted.
     *
     * @param $urlWildcardId
     *
     * @return \EzSystems\EzPlatformRest\Server\Values\NoContent
     */
    public function deleteURLWildcard($urlWildcardId)
    {
        $this->urlWildcardService->remove(
            $this->urlWildcardService->load($urlWildcardId)
        );

        return new Values\NoContent();
    }
}

class_alias(URLWildcard::class, 'EzSystems\EzPlatformRest\Server\Controller\URLWildcard');

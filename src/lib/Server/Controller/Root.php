<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Controller;

use Ibexa\Contracts\Rest\Exceptions\NotFoundException;
use Ibexa\Rest\Server\Controller as RestController;
use Ibexa\Rest\Server\Service\RootResourceBuilderInterface;

/**
 * Root controller.
 */
class Root extends RestController
{
    /**
     * @var RootResourceBuilderInterface
     */
    private $rootResourceBuilder;

    public function __construct($rootResourceBuilder)
    {
        $this->rootResourceBuilder = $rootResourceBuilder;
    }

    /**
     * List the root resources of the eZ Publish installation.
     *
     * @return \EzSystems\EzPlatformRest\Values\Root
     */
    public function loadRootResource()
    {
        return $this->rootResourceBuilder->buildRootResource();
    }

    /**
     * Catch-all for REST requests.
     *
     * @throws \EzSystems\EzPlatformRest\Exceptions\NotFoundException
     */
    public function catchAll()
    {
        throw new NotFoundException('No such route');
    }
}

class_alias(Root::class, 'EzSystems\EzPlatformRest\Server\Controller\Root');

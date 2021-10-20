<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Values;

use eZ\Publish\API\Repository\Values\ContentType\ContentType;
use Ibexa\Rest\Value as RestValue;

/**
 * ContentTypeGroup list view model.
 */
class ContentTypeGroupRefList extends RestValue
{
    /**
     * Content type.
     *
     * @var \eZ\Publish\API\Repository\Values\ContentType\ContentType
     */
    public $contentType;

    /**
     * Content type groups of the content type.
     *
     * @var \eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroup[]
     */
    public $contentTypeGroups;

    /**
     * Construct.
     *
     * @param \eZ\Publish\API\Repository\Values\ContentType\ContentType $contentType
     * @param \eZ\Publish\API\Repository\Values\ContentType\ContentTypeGroup[] $contentTypeGroups
     */
    public function __construct(ContentType $contentType, array $contentTypeGroups)
    {
        $this->contentType = $contentType;
        $this->contentTypeGroups = $contentTypeGroups;
    }
}

class_alias(ContentTypeGroupRefList::class, 'EzSystems\EzPlatformRest\Server\Values\ContentTypeGroupRefList');

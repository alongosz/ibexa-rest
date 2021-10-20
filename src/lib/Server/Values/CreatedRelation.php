<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Struct representing a freshly created relation.
 */
class CreatedRelation extends ValueObject
{
    /**
     * The created relation.
     *
     * @var \EzSystems\EzPlatformRest\Server\Values\RestRelation
     */
    public $relation;
}

class_alias(CreatedRelation::class, 'EzSystems\EzPlatformRest\Server\Values\CreatedRelation');

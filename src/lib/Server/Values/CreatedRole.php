<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Struct representing a freshly created Role.
 */
class CreatedRole extends ValueObject
{
    /**
     * The created role.
     *
     * @var \EzSystems\EzPlatformRest\Server\Values\RestRole
     */
    public $role;
}

class_alias(CreatedRole::class, 'EzSystems\EzPlatformRest\Server\Values\CreatedRole');

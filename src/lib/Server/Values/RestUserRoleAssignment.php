<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Values;

use eZ\Publish\API\Repository\Values\User\UserRoleAssignment;
use Ibexa\Rest\Value as RestValue;

/**
 * RestUserRoleAssignment view model.
 */
class RestUserRoleAssignment extends RestValue
{
    /**
     * Role assignment.
     *
     * @var \eZ\Publish\API\Repository\Values\User\UserRoleAssignment
     */
    public $roleAssignment;

    /**
     * User ID to which the role is assigned.
     *
     * @var mixed
     */
    public $id;

    /**
     * Construct.
     *
     * @param \eZ\Publish\API\Repository\Values\User\UserRoleAssignment $roleAssignment
     * @param mixed $id
     */
    public function __construct(UserRoleAssignment $roleAssignment, $id)
    {
        $this->roleAssignment = $roleAssignment;
        $this->id = $id;
    }
}

class_alias(RestUserRoleAssignment::class, 'EzSystems\EzPlatformRest\Server\Values\RestUserRoleAssignment');

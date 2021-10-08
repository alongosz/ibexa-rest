<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Exceptions;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserConflictException extends AuthenticationException
{
}

class_alias(UserConflictException::class, 'EzSystems\EzPlatformRest\Server\Exceptions\UserConflictException');

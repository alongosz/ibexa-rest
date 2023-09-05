<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Exceptions;

use Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeValidationException as APIContentTypeValidationException;

/**
 * @internal
 */
final class ContentTypeValidationException extends BadRequestException
{
    public function __construct(APIContentTypeValidationException $e)
    {
        parent::__construct($e->getMessage(), $e->getCode(), $e);
    }
}

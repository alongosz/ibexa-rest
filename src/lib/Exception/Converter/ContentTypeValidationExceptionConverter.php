<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Exception\Converter;

use Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeValidationException as APIContentTypeValidationException;
use Ibexa\Contracts\Core\Repository\Exceptions\Exception as RepositoryException;
use Ibexa\Rest\Server\Exceptions\ContentTypeValidationException;
use Throwable;

final class ContentTypeValidationExceptionConverter implements RepositoryExceptionConverterInterface
{
    /**
     * @param \Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeValidationException $exception
     */
    public function convert(RepositoryException $exception): Throwable
    {
        return new ContentTypeValidationException($exception);
    }

    public function supports(RepositoryException $exception): bool
    {
        return $exception instanceof APIContentTypeValidationException;
    }
}

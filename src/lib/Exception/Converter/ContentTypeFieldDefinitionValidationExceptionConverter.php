<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Exception\Converter;

use Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeFieldDefinitionValidationException as APIContentTypeFieldDefinitionValidationException;
use Ibexa\Contracts\Core\Repository\Exceptions\Exception as RepositoryException;
use Ibexa\Rest\Server\Exceptions\ContentTypeFieldDefinitionValidationException;
use Throwable;

final class ContentTypeFieldDefinitionValidationExceptionConverter implements RepositoryExceptionConverterInterface
{
    /**
     * @param \Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeFieldDefinitionValidationException $exception
     */
    public function convert(RepositoryException $exception): Throwable
    {
        return new ContentTypeFieldDefinitionValidationException($exception);
    }

    public function supports(RepositoryException $exception): bool
    {
        return $exception instanceof APIContentTypeFieldDefinitionValidationException;
    }
}

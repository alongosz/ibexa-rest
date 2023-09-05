<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Exceptions;

use Ibexa\Contracts\Core\Repository\Exceptions\ContentTypeFieldDefinitionValidationException as APIContentTypeFieldDefinitionValidationException;

/**
 * @internal
 */
final class ContentTypeFieldDefinitionValidationException extends BadRequestException
{
    /** @var array<string, \Ibexa\Core\FieldType\ValidationError[]> */
    private array $fieldDefinitionErrors;

    public function __construct(APIContentTypeFieldDefinitionValidationException $e)
    {
        $this->fieldDefinitionErrors = $e->getFieldErrors();

        parent::__construct($e->getMessage(), $e->getCode(), $e);
    }

    /**
     * @return array<string, \Ibexa\Core\FieldType\ValidationError[]>
     */
    public function getFieldDefinitionErrors(): array
    {
        return $this->fieldDefinitionErrors;
    }
}

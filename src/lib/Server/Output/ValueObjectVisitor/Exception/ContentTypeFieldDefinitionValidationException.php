<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Output\ValueObjectVisitor\Exception;

use Ibexa\Contracts\Core\Repository\Values\Translation;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;
use Ibexa\Rest\Server\Output\ValueObjectVisitor\BadRequestException;

/**
 * ContentTypeFieldDefinitionValidationException value object visitor.
 */
final class ContentTypeFieldDefinitionValidationException extends BadRequestException
{
    /**
     * @param \Ibexa\Rest\Server\Exceptions\ContentTypeFieldDefinitionValidationException $data
     */
    protected function generateErrorDetails(Visitor $visitor, Generator $generator, $data): void
    {
        $generator->startList('fieldDefinitions');
        foreach ($data->getFieldDefinitionErrors() as $fieldDefinitionIdentifier => $validationErrors) {
            $this->generateFieldDefinitionErrors(
                $generator,
                $fieldDefinitionIdentifier,
                $validationErrors
            );
        }
        $generator->endList('fieldDefinitions');
    }

    private function getMessage(Translation $translation): string
    {
        // non-SOLID due to an issue with core Translation abstract
        if (!$translation instanceof Translation\Message && !$translation instanceof Translation\Plural) {
            return '';
        }

        return (string)$translation;
    }

    /**
     * @param array<\Ibexa\Contracts\Core\FieldType\ValidationError> $validationErrors
     */
    private function generateFieldDefinitionErrors(
        Generator $generator,
        string $fieldDefinitionIdentifier,
        array $validationErrors
    ): void {
        $generator->startHashElement('fieldDefinition');
        $generator->attribute('fieldDefinitionIdentifier', $fieldDefinitionIdentifier);

        $generator->startList('errors');
        foreach ($validationErrors as $validationError) {
            $generator->startHashElement('error');

            $generator->valueElement('target', $validationError->getTarget());

            $generator->valueElement(
                'message',
                $this->getMessage($validationError->getTranslatableMessage())
            );

            $generator->endHashElement('error');
        }
        $generator->endList('errors');
        $generator->endHashElement('fieldDefinition');
    }
}

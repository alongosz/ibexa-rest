<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Output\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;

/**
 * BadRequestException value object visitor.
 */
class BadRequestException extends Exception
{
    /**
     * Returns HTTP status code.
     *
     * @return int
     */
    protected function getStatus(): int
    {
        return 400;
    }

    /**
     * @param \Throwable $data
     */
    protected function generateErrorDetails(Visitor $visitor, Generator $generator, $data): void
    {
        // Nothing to do, non-abstract due to BC
    }

    /**
     * Visit struct returned by controllers.
     *
     * @param \Throwable $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('ErrorMessage');

        $statusCode = $this->getStatus();
        $visitor->setStatus($statusCode);
        $visitor->setHeader('Content-Type', $generator->getMediaType('ErrorMessage'));

        $generator->valueElement('errorCode', $statusCode);

        $generator->valueElement(
            'errorMessage',
            self::$httpStatusCodes[$statusCode] ?? self::$httpStatusCodes[500]
        );

        $generator->valueElement('errorDescription', $data->getMessage());

        $generator->startHashElement('errorDetails');
        $this->generateErrorDetails($visitor, $generator, $data);
        $generator->endHashElement('errorDetails');

        if ($this->debug) {
            $generator->valueElement('trace', $data->getTraceAsString());
            $generator->valueElement('file', $data->getFile());
            $generator->valueElement('line', $data->getLine());
        }

        $generator->endObjectElement('ErrorMessage');
    }
}

class_alias(BadRequestException::class, 'EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor\BadRequestException');

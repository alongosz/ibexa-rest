<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Input\Parser\Aggregation;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\UserMetadataTermAggregation;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Exceptions;

final class UserMetadataTermAggregationParser extends AbstractTermAggregationParser
{
    protected function getAggregationName(): string
    {
        return 'UserMetadataTermAggregation';
    }

    protected function parseAggregation(array $data, ParsingDispatcher $parsingDispatcher): AbstractTermAggregation
    {
        if (!array_key_exists('type', $data)) {
            throw new Exceptions\Parser("Missing 'type' element for UserMetadataTerm.");
        }

        $this->assertTypeValue($data['type']);

        return new UserMetadataTermAggregation(
            $data['name'],
            $data['type']
        );
    }

    private function assertTypeValue(string $type): void
    {
        $allowedValues = [
            UserMetadataTermAggregation::OWNER,
            UserMetadataTermAggregation::GROUP,
            UserMetadataTermAggregation::MODIFIER,
        ];

        if (!in_array($type, $allowedValues)) {
            throw new Exceptions\Parser(
                sprintf(
                    "Invalid 'type' value. Expected one of %s, got: %s",
                    implode(', ', $allowedValues),
                    $type
                )
            );
        }
    }
}

class_alias(UserMetadataTermAggregationParser::class, 'EzSystems\EzPlatformRest\Server\Input\Parser\Aggregation\UserMetadataTermAggregationParser');

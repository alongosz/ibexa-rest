<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Input\Parser\Aggregation\Field;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\Field\KeywordTermAggregation;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Server\Input\Parser\Aggregation\AbstractTermAggregationParser;
use Ibexa\Rest\Exceptions;

final class KeywordTermAggregationParser extends AbstractTermAggregationParser
{
    protected function getAggregationName(): string
    {
        return 'KeywordTermAggregation';
    }

    protected function parseAggregation(array $data, ParsingDispatcher $parsingDispatcher): AbstractTermAggregation
    {
        if (!array_key_exists('contentTypeIdentifier', $data)) {
            throw new Exceptions\Parser("Missing 'contentTypeIdentifier' element for {$this->getAggregationName()}");
        }

        if (!array_key_exists('fieldDefinitionIdentifier', $data)) {
            throw new Exceptions\Parser("Missing 'fieldDefinitionIdentifier' element for {$this->getAggregationName()}.");
        }

        return new KeywordTermAggregation(
            $data['name'],
            $data['contentTypeIdentifier'],
            $data['fieldDefinitionIdentifier']
        );
    }
}

class_alias(KeywordTermAggregationParser::class, 'EzSystems\EzPlatformRest\Server\Input\Parser\Aggregation\Field\KeywordTermAggregationParser');

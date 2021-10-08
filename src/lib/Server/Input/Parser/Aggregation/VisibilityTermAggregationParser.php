<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Rest\Server\Input\Parser\Aggregation;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\VisibilityTermAggregation;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

final class VisibilityTermAggregationParser extends AbstractTermAggregationParser
{
    protected function getAggregationName(): string
    {
        return 'VisibilityTermAggregation';
    }

    protected function parseAggregation(array $data, ParsingDispatcher $parsingDispatcher): AbstractTermAggregation
    {
        return new VisibilityTermAggregation($data['name']);
    }
}

class_alias(VisibilityTermAggregationParser::class, 'EzSystems\EzPlatformRest\Server\Input\Parser\Aggregation\VisibilityTermAggregationParser');

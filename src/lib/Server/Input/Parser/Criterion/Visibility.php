<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Input\Parser\Criterion;

use Ibexa\Rest\Input\BaseParser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Exceptions;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility as VisibilityCriterion;

/**
 * Parser for Visibility Criterion.
 */
class Visibility extends BaseParser
{
    /**
     * Parses input structure to a Visibility Criterion object.
     *
     * @param array $data
     * @param \EzSystems\EzPlatformRest\Input\ParsingDispatcher $parsingDispatcher
     *
     * @throws \EzSystems\EzPlatformRest\Exceptions\Parser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
        if (!array_key_exists('VisibilityCriterion', $data)) {
            throw new Exceptions\Parser('Invalid <VisibilityCriterion> format');
        }

        if ($data['VisibilityCriterion'] != VisibilityCriterion::VISIBLE && $data['VisibilityCriterion'] != VisibilityCriterion::HIDDEN) {
            throw new Exceptions\Parser('Invalid <VisibilityCriterion> format');
        }

        return new VisibilityCriterion((int)$data['VisibilityCriterion']);
    }
}

class_alias(Visibility::class, 'EzSystems\EzPlatformRest\Server\Input\Parser\Criterion\Visibility');

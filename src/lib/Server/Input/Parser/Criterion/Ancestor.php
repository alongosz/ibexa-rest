<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Input\Parser\Criterion;

use Ibexa\Rest\Input\BaseParser;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Exceptions;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Ancestor as AncestorCriterion;

/**
 * Parser for Ancestor Criterion.
 */
class Ancestor extends BaseParser
{
    /**
     * Parses input structure to a Criterion object.
     *
     * @param array $data
     * @param \EzSystems\EzPlatformRest\Input\ParsingDispatcher $parsingDispatcher
     *
     * @throws \EzSystems\EzPlatformRest\Exceptions\Parser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\Criterion\Ancestor
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
        if (!array_key_exists('AncestorCriterion', $data)) {
            throw new Exceptions\Parser('Invalid <AncestorCriterion> format');
        }

        return new AncestorCriterion(explode(',', $data['AncestorCriterion']));
    }
}

class_alias(Ancestor::class, 'EzSystems\EzPlatformRest\Server\Input\Parser\Criterion\Ancestor');

<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzPlatformRest\Tests\Server\Input\Parser;

use eZ\Publish\API\Repository\Values\Content\Query;
use EzSystems\EzPlatformRest\Server\Input\Parser\ContentQuery as QueryParser;

class QueryParserTest extends BaseTest
{
    public function testParseEmptyQuery()
    {
        $inputArray = [
            'Filter' => [],
            'Query' => [],
        ];

        $parsingDispatcher = $this->getParsingDispatcherMock();
        $parser = $this->getParser();

        $result = $parser->parse($inputArray, $parsingDispatcher);

        $expectedQuery = new Query();

        $this->assertEquals($expectedQuery, $result);
    }

    public function testDispatchOneFilter()
    {
        $inputArray = [
            'Filter' => ['ContentTypeIdentifierCriterion' => 'article'],
            'Query' => [],
        ];

        $parsingDispatcher = $this->getParsingDispatcherMock();
        $parsingDispatcher
            ->expects($this->once())
            ->method('parse')
            ->with(['ContentTypeIdentifierCriterion' => 'article'])
            ->willReturn(new Query\Criterion\ContentTypeIdentifier('article'));

        $parser = $this->getParser();

        $result = $parser->parse($inputArray, $parsingDispatcher);

        $expectedQuery = new Query();
        $expectedQuery->filter = new Query\Criterion\ContentTypeIdentifier('article');

        $this->assertEquals($expectedQuery, $result);
    }

    public function testDispatchMoreThanOneFilter()
    {
        $inputArray = [
            'Filter' => ['ContentTypeIdentifierCriterion' => 'article', 'ParentLocationIdCriterion' => 762],
            'Query' => [],
        ];

        $parsingDispatcher = $this->getParsingDispatcherMock();
        $parsingDispatcher
            ->expects($this->at(0))
            ->method('parse')
            ->with(['ContentTypeIdentifierCriterion' => 'article'])
            ->willReturn(new Query\Criterion\ContentTypeIdentifier('article'));
        $parsingDispatcher
            ->expects($this->at(1))
            ->method('parse')
            ->with(['ParentLocationIdCriterion' => 762])
            ->willReturn(new Query\Criterion\ParentLocationId(762));

        $parser = $this->getParser();

        $result = $parser->parse($inputArray, $parsingDispatcher);

        $expectedQuery = new Query();
        $expectedQuery->filter = new Query\Criterion\LogicalAnd([
            new Query\Criterion\ContentTypeIdentifier('article'),
            new Query\Criterion\ParentLocationId(762),
        ]);

        $this->assertEquals($expectedQuery, $result);
    }

    public function testDispatchOneQueryItem()
    {
        $inputArray = [
            'Query' => ['ContentTypeIdentifierCriterion' => 'article'],
            'Filter' => [],
        ];

        $parsingDispatcher = $this->getParsingDispatcherMock();
        $parsingDispatcher
            ->expects($this->once())
            ->method('parse')
            ->with(['ContentTypeIdentifierCriterion' => 'article'])
            ->willReturn(new Query\Criterion\ContentTypeIdentifier('article'));

        $parser = $this->getParser();

        $result = $parser->parse($inputArray, $parsingDispatcher);

        $expectedQuery = new Query();
        $expectedQuery->query = new Query\Criterion\ContentTypeIdentifier('article');

        $this->assertEquals($expectedQuery, $result);
    }

    public function testDispatchMoreThanOneQueryItem()
    {
        $inputArray = [
            'Query' => ['ContentTypeIdentifierCriterion' => 'article', 'ParentLocationIdCriterion' => 762],
            'Filter' => [],
        ];

        $parsingDispatcher = $this->getParsingDispatcherMock();
        $parsingDispatcher
            ->expects($this->at(0))
            ->method('parse')
            ->with(['ContentTypeIdentifierCriterion' => 'article'])
            ->willReturn(new Query\Criterion\ContentTypeIdentifier('article'));
        $parsingDispatcher
            ->expects($this->at(1))
            ->method('parse')
            ->with(['ParentLocationIdCriterion' => 762])
            ->willReturn(new Query\Criterion\ParentLocationId(762));

        $parser = $this->getParser();

        $result = $parser->parse($inputArray, $parsingDispatcher);

        $expectedQuery = new Query();
        $expectedQuery->query = new Query\Criterion\LogicalAnd([
            new Query\Criterion\ContentTypeIdentifier('article'),
            new Query\Criterion\ParentLocationId(762),
        ]);

        $this->assertEquals($expectedQuery, $result);
    }

    /**
     * Returns the session input parser.
     */
    protected function internalGetParser()
    {
        return new QueryParser();
    }
}

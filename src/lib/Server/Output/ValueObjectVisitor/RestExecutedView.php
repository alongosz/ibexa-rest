<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Exceptions\UnauthorizedException;
use eZ\Publish\API\Repository\Values\Content as ApiValues;
use EzSystems\EzPlatformRest\Exceptions;
use EzSystems\EzPlatformRest\Output\ValueObjectVisitor;
use EzSystems\EzPlatformRest\Output\Generator;
use EzSystems\EzPlatformRest\Output\Visitor;
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use EzSystems\EzPlatformRest\Server\Values\RestContent as RestContentValue;

/**
 * Section value object visitor.
 */
class RestExecutedView extends ValueObjectVisitor
{
    /**
     * Location service.
     *
     * @var \eZ\Publish\API\Repository\LocationService
     */
    protected $locationService;

    /**
     * Content service.
     *
     * @var \eZ\Publish\API\Repository\ContentService
     */
    protected $contentService;

    /**
     * @param \eZ\Publish\API\Repository\LocationService $locationService
     * @param \eZ\Publish\API\Repository\ContentService $contentService
     */
    public function __construct(
        LocationService $locationService,
        ContentService $contentService
    ) {
        $this->locationService = $locationService;
        $this->contentService = $contentService;
    }

    /**
     * Visit struct returned by controllers.
     *
     * @param \EzSystems\EzPlatformRest\Output\Visitor $visitor
     * @param \EzSystems\EzPlatformRest\Output\Generator $generator
     * @param \EzSystems\EzPlatformRest\Server\Values\RestExecutedView $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        $generator->startObjectElement('View');
        $visitor->setHeader('Content-Type', $generator->getMediaType('View'));

        $generator->startAttribute(
            'href',
            $this->router->generate('ezpublish_rest_views_load', ['viewId' => $data->identifier])
        );
        $generator->endAttribute('href');

        $generator->startValueElement('identifier', $data->identifier);
        $generator->endValueElement('identifier');

        // BEGIN Query
        $generator->startObjectElement('Query');
        $generator->endObjectElement('Query');
        // END Query

        // BEGIN Result
        $generator->startObjectElement('Result', 'ViewResult');
        $generator->startAttribute(
            'href',
            $this->router->generate('ezpublish_rest_views_load_results', ['viewId' => $data->identifier])
        );
        $generator->endAttribute('href');

        // BEGIN Result metadata
        $generator->startValueElement('count', $data->searchResults->totalCount);
        $generator->endValueElement('count');

        $generator->startValueElement('time', $data->searchResults->time);
        $generator->endValueElement('time');

        $generator->startValueElement('timedOut', $generator->serializeBool($data->searchResults->timedOut));
        $generator->endValueElement('timedOut');

        $generator->startValueElement('maxScore', $data->searchResults->maxScore);
        $generator->endValueElement('maxScore');
        // END Result metadata

        // BEGIN searchHits
        $generator->startHashElement('searchHits');
        $generator->startList('searchHit');

        foreach ($data->searchResults->searchHits as $searchHit) {
            $generator->startObjectElement('searchHit');

            $generator->startAttribute('score', (float)$searchHit->score);
            $generator->endAttribute('score');

            $generator->startAttribute('index', (string)$searchHit->index);
            $generator->endAttribute('index');

            $generator->startObjectElement('value');

            // @todo Refactor
            if ($searchHit->valueObject instanceof ApiValues\Content) {
                /** @var \eZ\Publish\API\Repository\Values\Content\Content $searchHit->valueObject */
                $contentInfo = $searchHit->valueObject->contentInfo;

                try {
                    $mainLocation = $this->locationService->loadLocation($contentInfo->mainLocationId);
                } catch (NotFoundException | UnauthorizedException $e) {
                    $mainLocation = null;
                }

                $valueObject = new RestContentValue(
                    $contentInfo,
                    $mainLocation,
                    $searchHit->valueObject,
                    $searchHit->valueObject->getContentType(),
                    $this->contentService->loadRelations($searchHit->valueObject->getVersionInfo())
                );
            } elseif ($searchHit->valueObject instanceof ApiValues\Location) {
                $valueObject = $searchHit->valueObject;
            } elseif ($searchHit->valueObject instanceof ApiValues\ContentInfo) {
                $valueObject = new RestContentValue($searchHit->valueObject);
            } else {
                throw new Exceptions\InvalidArgumentException('Unhandled object type');
            }

            $visitor->visitValueObject($valueObject);
            $generator->endObjectElement('value');
            $generator->endObjectElement('searchHit');
        }

        $generator->endList('searchHit');

        $generator->endHashElement('searchHits');
        // END searchHits

        // BEGIN aggregations
        $generator->startList('aggregations');
        foreach ($data->searchResults->aggregations as $aggregationResult) {
            $visitor->visitValueObject($aggregationResult);
        }
        $generator->endList('aggregations');
        // END aggregations

        $generator->endObjectElement('Result');
        // END Result

        $generator->endObjectElement('View');
    }
}

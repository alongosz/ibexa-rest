<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Ibexa\Rest\Server\Output\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;

/**
 * CreatedObjectState value object visitor.
 *
 * @todo coverage add test
 */
class CreatedObjectState extends RestObjectState
{
    /**
     * Visit struct returned by controllers.
     *
     * @param \EzSystems\EzPlatformRest\Output\Visitor $visitor
     * @param \EzSystems\EzPlatformRest\Output\Generator $generator
     * @param \EzSystems\EzPlatformRest\Server\Values\CreatedObjectState $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data)
    {
        parent::visit($visitor, $generator, $data->objectState);
        $visitor->setHeader(
            'Location',
            $this->router->generate(
                'ezpublish_rest_loadObjectState',
                [
                    'objectStateGroupId' => $data->objectState->groupId,
                    'objectStateId' => $data->objectState->objectState->id,
                ]
            )
        );
        $visitor->setStatus(201);
    }
}

class_alias(CreatedObjectState::class, 'EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor\CreatedObjectState');

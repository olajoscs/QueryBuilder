<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\JoinContainer as JoinContainerInterface;


/**
 * Class JoinContainer
 *
 *
 */
abstract class JoinContainer extends Container implements JoinContainerInterface
{
    /**
     * @var JoinElement[]
     */
    protected $list = [];
}
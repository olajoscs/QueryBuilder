<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;


/**
 * Class GroupByContainer
 *
 *
 */
abstract class GroupByContainer extends Container
{
    /**
     * @var GroupByElement[]
     */
    protected $list = [];
}
<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;


/**
 * Class GroupByContainer
 *
 * Database independent GroupByContainer
 * Contains only the logic to build the model
 */
abstract class GroupByContainer extends Container
{
    /**
     * @var GroupByElement[]
     */
    protected $list = [];
}
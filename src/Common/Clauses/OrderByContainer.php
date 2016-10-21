<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByContainer as OrderByContainerInterface;


/**
 * Class OrderByContainer
 *
 * Database independent OrderByContainer
 * Contains only the logic to build the model
 */
abstract class OrderByContainer extends Container implements OrderByContainerInterface
{
    /**
     * @var OrderByElement[]
     */
    protected $list = [];
}
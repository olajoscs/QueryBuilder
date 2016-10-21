<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByContainer as OrderByContainerInterface;


/**
 * Class OrderByContainer
 *
 *
 */
abstract class OrderByContainer extends Container implements OrderByContainerInterface
{
    /**
     * @var OrderByElement[]
     */
    protected $list = [];
}
<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;


/**
 * Class WhereContainer
 *
 *
 */
abstract class WhereContainer extends Container implements WhereContainerInterface
{
    /**
     * @var array The list of the binding parameters
     */
    protected $parameters = [];

    /**
     * @var WhereElement[]
     */
    protected $list = [];


    /**
     * @inheritdoc
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
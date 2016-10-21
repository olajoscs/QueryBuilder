<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\WhereContainer as WhereContainerInterface;


/**
 * Class WhereContainer
 *
 * Database independent WhereContainer object
 * Contains only the logic to build the model
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
     * @var int Counter of the parameters
     */
    protected $bindingCount = 0;


    /**
     * @inheritdoc
     */
    public function getParameters()
    {
        return $this->parameters;
    }


    /**
     * @inheritdoc
     */
    public function getBindingCount()
    {
        return $this->bindingCount++;
    }
}
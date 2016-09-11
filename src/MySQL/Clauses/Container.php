<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Container as ContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\Element;

abstract class Container implements ContainerInterface
{
    /**
     * @var Element[]
     */
    protected $list = [];

    /**
     * Add an element to the container
     *
     * @param Element $element
     *
     * @return static
     */
    public function add(Element $element)
    {
        $this->list[] = $element;

        return $this;
    }


    /**
     * Return the elements of the container
     *
     * @return Element[]
     */
    public function get()
    {
        return $this->list;
    }


    /**
     * Return whether the container has elemnents or not
     *
     * @return bool
     */
    public function has()
    {
        return !empty($this->get());
    }
}
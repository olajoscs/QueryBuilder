<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Container as ContainerInterface;
use OlajosCs\QueryBuilder\Contracts\Clauses\Element;

/**
 * Class Container
 *
 * Database independent abstract container class.
 * Contains only the logic to build the model.
 * Parent of all the container objects.
 */
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
     * Return whether the container has elemnents or not
     *
     * @return bool
     */
    public function has()
    {
        return !empty($this->get());
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
}

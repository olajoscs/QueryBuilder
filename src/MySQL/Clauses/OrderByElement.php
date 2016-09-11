<?php

namespace OlajosCs\QueryBuilder\MySQL\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\Element;

/**
 * Class OrderByElement
 *
 * Defines an element in the order by clause
 */
class OrderByElement implements Element
{
    /**
     * Defines the nulls last order
     */
    const NULLS_LAST = 'nl';

    /**
     * Defines the nulls first order
     */
    const NULLS_FIRST = 'nf';

    /**
     * Ascending order
     */
    const ORDER_ASC = 'ASC';

    /**
     * Descending order
     */
    const ORDER_DESC = 'DESC';

    /**
     * @var string The name of the field to order
     */
    private $field;

    /**
     * @var string The order of the order
     */
    private $order = self::ORDER_ASC;

    /**
     * @var string The position of null fields
     */
    private $nullsPosition = self::NULLS_FIRST;


    /**
     * Create a new order by clause
     *
     * @param string $field         Name of the field to order by
     * @param string $order         Type of the order (one of the OrderByElement::ORDER_ constants)
     * @param string $nullsPosition Position of the null values (one of the OrderByElement::NULLS_ constans)
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($field, $order = null, $nullsPosition = null)
    {
        $this->field = $field;

        if ($order !== null) {
            $this->setOrder($order);
        }

        if ($nullsPosition !== null) {
            $this->setNullsPosition($nullsPosition);
        }
    }


    /**
     * Return the field to order
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }


    /**
     * Return the order of the order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }


    /**
     * Return the nulls position
     *
     * @return string
     */
    public function getNullsPosition()
    {
        return $this->nullsPosition;
    }


    /**
     * Set the nulls position
     *
     * @param string $nullsPosition One of the NULLS_ constants
     *
     * @return static
     * @throws \InvalidArgumentException
     */
    private function setNullsPosition($nullsPosition)
    {
        if (!\in_array($nullsPosition, [self::NULLS_FIRST, self::NULLS_LAST])) {
            throw new \InvalidArgumentException('Invalid nulls position: ' . $nullsPosition);
        }

        $this->nullsPosition = $nullsPosition;

        return $this;
    }


    /**
     * Sets the order of the order
     *
     * @param string $order
     *
     * @return static
     * @throws \InvalidArgumentException
     */
    private function setOrder($order)
    {
        if (!\in_array($order, [self::ORDER_ASC, self::ORDER_DESC])) {
            throw new \InvalidArgumentException('Invalid order: ' . $order);
        }

        $this->order = $order;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function asString()
    {
        if ($this->nullsPosition === self::NULLS_LAST) {
            $this->field         = '-' . $this->field;
            $this->order         = self::ORDER_ASC ? self::ORDER_DESC : self::ORDER_ASC;
            $this->nullsPosition = self::NULLS_FIRST;
        }

        return sprintf('%s %s', $this->field, $this->order);
    }
}
<?php

namespace OlajosCs\QueryBuilder\Common\Clauses;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByElement as OrderByElementInterface;

/**
 * Class OrderByElement
 *
 * Database independent OrderByElement model
 * Contains only the logic to build the model
 */
abstract class OrderByElement implements OrderByElementInterface
{
    /**
     * @var string The name of the field to order
     */
    protected $field;

    /**
     * @var string The order of the order
     */
    protected $order = self::ORDER_ASC;

    /**
     * @var string The position of null fields
     */
    protected $nullsPosition = self::NULLS_FIRST;


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
     * @inheritdoc
     */
    public function getField()
    {
        return $this->field;
    }


    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return $this->order;
    }


    /**
     * @inheritdoc
     */
    public function getNullsPosition()
    {
        return $this->nullsPosition;
    }
}
<?php

namespace OlajosCs\QueryBuilder\Contracts;

interface Query
{
    /**
     * Return the query as a string
     *
     * @return mixed
     */
    public function asString();
}

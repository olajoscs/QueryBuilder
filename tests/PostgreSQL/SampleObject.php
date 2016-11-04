<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;


/**
 * Class SampleObject
 *
 * A small object to test the query builder
 */
class SampleObject
{
    public $id;
    public $languageId;
    public $field;


    public function __construct()
    {
    }


    /**
     * Create a test object
     *
     * @param int    $id
     * @param int    $languageId
     * @param string $field
     *
     * @return SampleObject
     */
    public static function create($id, $languageId, $field)
    {
        $object = new SampleObject();

        $object->id         = $id;
        $object->languageId = $languageId;
        $object->field      = $field;

        return $object;
    }
}
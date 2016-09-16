<?php

namespace OlajosCs\QueryBuilder\MySQL;


/**
 * Class SampleObject
 *
 *
 */
class SampleObject
{
    public $id;
    public $languageId;
    public $field;


    public function __construct()
    {
    }


    public static function create($id, $languageId, $field)
    {
        $object = new SampleObject();

        $object->id         = $id;
        $object->languageId = $languageId;
        $object->field      = $field;

        return $object;
    }
}
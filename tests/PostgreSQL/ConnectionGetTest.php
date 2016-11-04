<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;
use OlajosCs\QueryBuilder\Exceptions\MultipleRowFoundException;
use OlajosCs\QueryBuilder\Exceptions\RowNotFoundException;

/**
 * Class SelectResultTest
 *
 * Testing the result and the getters for the connection class
 */
class ConnectionGetTest extends PostgreSQL
{
    /**
     * Test the default get method of the connection class
     *
     * @return void
     */
    public function testGet()
    {
        $result = $this->getConnection()->get(
            'SELECT * 
            FROM querybuilder_tests 
            ORDER BY id ASC 
            LIMIT 3'
        );

        $expected = [
            (object)[
                'id'         => '0',
                'languageId' => '1',
                'field'      => 'aaaa',
            ],
            (object)[
                'id'         => '1',
                'languageId' => '1',
                'field'      => 'bbbb',
            ],
            (object)[
                'id'         => '2',
                'languageId' => '1',
                'field'      => 'cccc',
            ],
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test the get as class method
     *
     * @return void
     */
    public function testGetAsClasses()
    {
        $result = $this->getConnection()->getAsClasses(
            'SELECT * 
            FROM querybuilder_tests 
            ORDER BY id ASC 
            LIMIT 3',
            [],
            SampleObject::class
        );

        $expected = [
            SampleObject::create('0', '1', 'aaaa'),
            SampleObject::create('1', '1', 'bbbb'),
            SampleObject::create('2', '1', 'cccc'),
        ];

        $this->assertEquals($expected, $result);


        $result = $this->getConnection()->getAsClasses(
            'SELECT * FROM querybuilder_tests WHERE id = :id',
            [
                'id' => 5,
            ],
            SampleObject::class
        );

        $expected = [
            SampleObject::create('5', '2', 'ffff'),
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test when we would like to get only one stdClass
     *
     * @return void
     */
    public function testGetOne()
    {
        $result = $this->getConnection()->getOne(
            'SELECT *
            FROM querybuilder_tests
            WHERE field = :field',
            [
                'field' => 'ffff',
            ]
        );

        $object = (object)[
            'id'         => '5',
            'languageId' => '2',
            'field'      => 'ffff',
        ];

        $this->assertEquals($object, $result);
    }


    /**
     * Test when more rows found for query then MultipleRowFoundException is thrown
     *
     * @return void
     */
    public function testGetOneMultipleFound()
    {
        $this->expectException(MultipleRowFoundException::class);

        $this->getConnection()->getOne(
            'SELECT *
            FROM querybuilder_tests
            WHERE id > :id',
            [
                'id' => 5,
            ]
        );
    }


    /**
     * Test when no rows found for query then RowNotFoundException is thrown
     *
     * @return void
     */
    public function testGetOneNotFound()
    {
        $this->expectException(RowNotFoundException::class);

        $this->getConnection()->getOne(
            'SELECT *
            FROM querybuilder_tests
            WHERE id = :id1 AND id = :id2',
            [
                'id1' => 5,
                'id2' => 6,
            ]
        );
    }


    /**
     * Test when we would like to get only one explicit class
     *
     * @return void
     */
    public function testGetOneClass()
    {
        $result = $this->getConnection()->getOneClass(
            'SELECT *
            FROM querybuilder_tests
            WHERE id = :id',
            [
                'id' => 1,
            ],
            SampleObject::class
        );

        $object = SampleObject::create('1', '1', 'bbbb');

        $this->assertEquals($object, $result);
    }


    /**
     * Test when the result must be only one field
     *
     * @return void
     */
    public function testGetOneField()
    {
        $result = $this->getConnection()->getOneField(
            'SELECT field
            FROM querybuilder_tests
            WHERE id = :id',
            [
                'id' => 1,
            ],
            'field'
        );

        $this->assertEquals('bbbb', $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()->getOneField(
            'SELECT field
            FROM querybuilder_tests
            WHERE id = :id',
            [
                'id' => 1,
            ],
            'id'
        );
    }


    /**
     * Test when you need an array of the given field
     *
     * @return void
     */
    public function testGetList()
    {
        $result = $this->getConnection()->getList(
            'SELECT field
            FROM querybuilder_tests
            WHERE id > :id',
            [
                'id' => 7,
            ],
            'field'
        );

        $expected = [
            'iiii',
            'jjjj',
        ];

        $this->assertEquals($expected, $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()->getList(
            'SELECT field
            FROM querybuilder_tests
            WHERE id > :id
            ORDER BY id ASC',
            [
                'id' => 7,
            ],
            'id'
        );
    }


    /**
     * Test when you need an array of stdClasses with a special key
     *
     * @return void
     */
    public function testGetWithKey()
    {
        $result = $this->getConnection()->getWithKey(
            'SELECT *
            FROM querybuilder_tests 
            WHERE id < :id
            ORDER BY id ASC',
            [
                'id' => 2,
            ],
            'field'
        );

        $expected = [
            'aaaa' => (object)[
                'id'         => '0',
                'languageId' => '1',
                'field'      => 'aaaa',
            ],
            'bbbb' => (object)[
                'id'         => '1',
                'languageId' => '1',
                'field'      => 'bbbb',
            ],
        ];

        $this->assertEquals($expected, $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()->getWithKey(
            'SELECT *
            FROM querybuilder_tests 
            WHERE id < :id
            ORDER BY id ASC',
            [
                'id' => 2,
            ],
            'asdf'
        );
    }


    /**
     * Test when you need an array of explicit classes with a special key
     *
     * @return void
     */
    public function testGetClassesWithKey()
    {
        $result = $this->getConnection()->getClassesWithKey(
            'SELECT *
            FROM querybuilder_tests 
            WHERE id < :id
            ORDER BY id ASC',
            [
                'id' => 2,
            ],
            SampleObject::class,
            [],
            'field'
        );

        $expected = [
            'aaaa' => SampleObject::create('0', '1', 'aaaa'),
            'bbbb' => SampleObject::create('1', '1', 'bbbb'),
        ];

        $this->assertEquals($expected, $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()->getClassesWithKey(
            'SELECT *
            FROM querybuilder_tests 
            WHERE id < :id
            ORDER BY id ASC',
            [
                'id' => 2,
            ],
            SampleObject::class,
            [],
            'asdf'
        );
    }


    /**
     * Test the executing custom query, if the result statement is needed
     *
     * @return void
     */
    public function testExecute()
    {
        $statement = $this->getConnection()->execute(
            'SELECT * FROM querybuilder_tests'
        );

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(10, $statement->rowCount());
    }


    /**
     * Test the executing custom query, if the result statement is needed
     *
     * @return void
     */
    public function testBinding()
    {
        $result = $this->getConnection()->execute(
            'SELECT current_timestamp > :date AS bigger',
            [
                'date' => new \DateTime('2006-09-16'),
            ]
        )->fetch(\PDO::FETCH_OBJ);

        $this->assertEquals(true, $result->bigger);


        $result = $this->getConnection()->execute(
            'select true = :true as "isTrue"',
            [
                'true' => true,
            ]
        )->fetch(\PDO::FETCH_OBJ);

        $this->assertEquals(true, $result->isTrue);


        $result = $this->getConnection()->execute(
            'select :null is unknown as "isNull"',
            [
                'null' => null,
            ]
        )->fetch(\PDO::FETCH_OBJ);

        $this->assertEquals(true, $result->isNull);


        $result = $this->getConnection()->getOneClass(
            'SELECT *
            FROM querybuilder_tests
            WHERE "id" = :id',
            [
                'id' => 4,
            ],
            SampleObject::class
        );

        $this->assertEquals(SampleObject::create('4', '1', 'eeee'), $result);


        $result = $this->getConnection()->getOneClass(
            'SELECT *
            FROM querybuilder_tests
            WHERE "field" = :field',
            [
                'field' => 'eeee',
            ],
            SampleObject::class
        );

        $this->assertEquals(SampleObject::create('4', '1', 'eeee'), $result);
    }


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }
}

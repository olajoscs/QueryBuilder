<?php

namespace OlajosCs\QueryBuilder\PostgreSQL;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;


/**
 * Class SelectGetTest
 *
 * Test the querybuilder
 */
class StatementGetTest extends PostgreSQLTestCase
{
    /**
     * Test the default get method of the connection class
     *
     * @return void
     */
    public function testGet()
    {
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 10)
            ->orderBy('id')
            ->limit(3)
            ->get();

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
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->orderBy('id')
            ->limit(3)
            ->getAsClasses(SampleObject::class);

        $expected = [
            SampleObject::create('0', '1', 'aaaa'),
            SampleObject::create('1', '1', 'bbbb'),
            SampleObject::create('2', '1', 'cccc'),
        ];

        $this->assertEquals($expected, $result);


        $result = $this->getQueryBuilderConnection()->getAsClasses(
            'SELECT * FROM "querybuilder_tests" WHERE "id" = :id',
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
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('field', '=', 'ffff')
            ->getOne();


        $object = (object)[
            'id'         => '5',
            'languageId' => '2',
            'field'      => 'ffff',
        ];

        $this->assertEquals($object, $result);
    }


    /**
     * Test when we would like to get only one explicit class
     *
     * @return void
     */
    public function testGetOneClass()
    {
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneClass(SampleObject::class);

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
        $result = $this->getQueryBuilderConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneField();

        $this->assertEquals('bbbb', $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getQueryBuilderConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneField('id');
    }


    /**
     * Test when you need an array of the given field
     *
     * @return void
     */
    public function testGetList()
    {
        $result = $this->getQueryBuilderConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '>', 7)
            ->getList();

        $expected = [
            'iiii',
            'jjjj',
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test when the required field is not found in the field of the rows
     *
     * @return void
     */
    public function testFieldNotFoundInGetList()
    {
        $this->expectException(FieldNotFoundException::class);

        $this->getQueryBuilderConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '>', 7)
            ->getList('hello');
    }


    /**
     * Test when you need an array of stdClasses with a special key
     *
     * @return void
     */
    public function testGetWithKey()
    {
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getWithKey('field');

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

        $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getWithKey('asdf');
    }


    /**
     * Test when you need an array of explicit classes with a special key
     *
     * @return void
     */
    public function testGetClassesWithKey()
    {
        $result = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getClassesWithKey(SampleObject::class, [], 'field');

        $expected = [
            'aaaa' => SampleObject::create('0', '1', 'aaaa'),
            'bbbb' => SampleObject::create('1', '1', 'bbbb'),
        ];

        $this->assertEquals($expected, $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getClassesWithKey(SampleObject::class, [], 'asdf');
    }


    /**
     * Test the executing custom query, if the result statement is needed
     *
     * @return void
     */
    public function testExecute()
    {
        $statement = $this->getQueryBuilderConnection()
            ->select()
            ->from('querybuilder_tests')
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(10, $statement->rowCount());
    }


    /**
     * Test a bit difficultier query
     *
     * @return void
     */
    public function testFull()
    {
        $result = $this->getQueryBuilderConnection()
            ->select(
                [
                    'field',
                    'languageId',
                ]
            )
            ->from('querybuilder_tests')
            ->join('querybuilder_test_languages', 'id', '=', 'languageId')
            ->where('querybuilder_tests.id', '>', 1)
            ->orderBy('field', OrderByElement::ORDER_DESC)
            ->limit(3)
            ->offset(2)
            ->get();

        $expected = [
            (object)[
                'field'      => 'hhhh',
                'languageId' => '2',
            ],
            (object)[
                'field'      => 'gggg',
                'languageId' => '2',
            ],
            (object)[
                'field'      => 'ffff',
                'languageId' => '2',
            ],
        ];

        $this->assertEquals($expected, $result);
    }


    /**
     * Test if empty array is returned if parameter array in WhereIn is empty
     *
     * @return void
     */
    public function testWhereInWithEmpty()
    {
        $connection = $this->getQueryBuilderConnection();

        $results = $connection
            ->select('id')
            ->from('querybuilder_tests')
            ->whereIn('id', [])
            ->get();

        $this->assertEquals([], $results);
    }


    /**
     * Test if all rows are returned if parameter array in WhereNotIn is empty
     *
     * @return void
     */
    public function testWhereNotInWithEmpty()
    {
        $connection = $this->getQueryBuilderConnection();

        $results = $connection
            ->select('id')
            ->from('querybuilder_tests')
            ->whereNotIn('id', [])
            ->get();

        $real = count($results);

        $all = $connection
            ->select($connection->createRawExpression('count(1) as counter'))
            ->from('querybuilder_tests')
            ->getOneField();

        $this->assertEquals($real, (int)$all);
    }


    /**
     * Test if empty list is returned when no rows found with the getList method
     *
     * @return void
     */
    public function testEmptyList()
    {
        $connection = $this->getQueryBuilderConnection();

        $results = $connection
            ->select('id')
            ->from('querybuilder_tests')
            ->whereIn('id', [])
            ->getList();

        $this->assertEquals([], $results);
    }


    /**
     * Test if empty list is returned when no rows found with the getList method
     *
     * @return void
     */
    public function testEmptyListWithKeys()
    {
        $connection = $this->getQueryBuilderConnection();

        $results = $connection
            ->select('id')
            ->from('querybuilder_tests')
            ->whereIn('id', [])
            ->getWithKey('id');

        $this->assertEquals([], $results);
    }
}
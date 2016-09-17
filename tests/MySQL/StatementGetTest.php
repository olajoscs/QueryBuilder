<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\Contracts\Clauses\OrderByElement;
use OlajosCs\QueryBuilder\Exceptions\FieldNotFoundException;


/**
 * Class SelectGetTest
 *
 * Test the querybuilder
 */
class StatementGetTest extends MySQL
{
    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->seed();
    }


    /**
     * Test the default get method of the connection class
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::get()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\Statement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::__construct()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGet()
    {
        $result = $this->getConnection()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getAsClasses()
     *
     * @return void
     */
    public function testGetAsClasses()
    {
        $result = $this->getConnection()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getOne()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetOne()
    {
        $result = $this->getConnection()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getOneClass()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetOneClass()
    {
        $result = $this->getConnection()
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
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getOneField()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetOneField()
    {
        $result = $this->getConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneField();

        $this->assertEquals('bbbb', $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '=', 1)
            ->getOneField('id');
    }


    /**
     * Test when you need an array of the given field
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getList()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetList()
    {
        $result = $this->getConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '>', 7)
            ->getList();

        $expected = [
            'iiii',
            'jjjj',
        ];

        $this->assertEquals($expected, $result);

        $this->expectException(FieldNotFoundException::class);

        $this->getConnection()
            ->select('field')
            ->from('querybuilder_tests')
            ->where('id', '>', 7)
            ->getList('id');
    }


    /**
     * Test when you need an array of stdClasses with a special key
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getWithKey()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetWithKey()
    {
        $result = $this->getConnection()
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

        $this->getConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getWithKey('asdf');
    }


    /**
     * Test when you need an array of explicit classes with a special key
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::getClassesWithKey()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testGetClassesWithKey()
    {
        $result = $this->getConnection()
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

        $this->getConnection()
            ->select()
            ->from('querybuilder_tests')
            ->where('id', '<', 2)
            ->getClassesWithKey(SampleObject::class, [], 'asdf');
    }


    /**
     * Test the executing custom query, if the result statement is needed
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::execute()
     *
     * @return void
     */
    public function testExecute()
    {
        $statement = $this->getConnection()
            ->select()
            ->from('querybuilder_tests')
            ->execute();

        $this->assertInstanceOf(\PDOStatement::class, $statement);
        $this->assertEquals(10, $statement->rowCount());
    }


    /**
     * Test a bit difficultier query
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::from()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::join()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::where()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::orderBy()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::limit()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::offset()
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\SelectStatement::get()
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::get()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::execute()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::bindParameters()
     * @covers \OlajosCs\QueryBuilder\MySQL\Connection::select()
     *
     * @covers \OlajosCs\QueryBuilder\MySQL\Statements\Common\WhereStatement::asString()
     *
     * @return void
     */
    public function testFull()
    {
        $result = $this->getConnection()
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
}
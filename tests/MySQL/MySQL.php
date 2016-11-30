<?php

namespace OlajosCs\QueryBuilder\MySQL;

use OlajosCs\QueryBuilder\ConnectionFactory;

abstract class MySQL extends \PHPUnit_Framework_TestCase
{
    /**
     * Seed the database with dummy data
     *
     * @return void
     */
    protected function seed()
    {
        $connection = $this->getConnection();

        $connection->getPdo()->prepare(
            'CREATE TABLE IF NOT EXISTS querybuilder_test_languages (
                  id INT,
                  code VARCHAR(2)
            )'
        )->execute();

        $connection->getPdo()->prepare(
            'CREATE TABLE IF NOT EXISTS querybuilder_tests (
                id INT,
                languageId INT,
                field VARCHAR(5)
            )'
        )->execute();

        $connection->getPdo()->prepare('truncate table querybuilder_tests')->execute();
        $connection->getPdo()->prepare('truncate table querybuilder_test_languages')->execute();

        $statement = $connection->getPdo()->prepare(
            'INSERT INTO querybuilder_test_languages (
                id, code
            ) VALUES 
            (:id1, :code1), 
            (:id2, :code2)'
        );

        $statement->bindValue('id1', 1, \PDO::PARAM_INT);
        $statement->bindValue('code1', 'en', \PDO::PARAM_STR);
        $statement->bindValue('id2', 2, \PDO::PARAM_INT);
        $statement->bindValue('code2', 'de', \PDO::PARAM_STR);

        $statement->execute();

        $sql = 'INSERT INTO querybuilder_tests (
                id, languageId, field
            ) VALUES';

        $binding = [];
        foreach ($this->getObjects() as $i => $object) {
            $binding[] = '(:id' . $i . ', :lang' . $i . ', :field' . $i . ')';
        }

        $statement = $connection->getPdo()->prepare($sql . implode(',', $binding));

        foreach ($this->getObjects() as $object) {
            foreach (get_object_vars($object) as $property => $value) {
                $statement->bindValue($property, $value);
            }
        }


        $statement->execute();
    }


    /**
     * Return a connection based on the config file
     *
     * @return Connection
     */
    protected function getConnection()
    {
        return ConnectionFactory::get('mysql');
    }


    /**
     * Generate dummy objects for database seeding
     *
     * @return \stdClass[]
     */
    protected function getObjects()
    {
        $return = [];
        $letters = 'abcdefghij';
        for ($i = 0; $i < 10; $i++) {

            $lang = $i < 5 ? 1 : 2;

            $return[] = (object)[
                'id' . $i    => $i,
                'lang' . $i  => $lang,
                'field' . $i => str_repeat($letters[$i], 4),
            ];
        }

        return $return;
    }
}
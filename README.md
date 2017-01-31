[![Build Status](https://travis-ci.org/olajoscs/QueryBuilder.svg?branch=master)](https://travis-ci.org/olajoscs/QueryBuilder)
[![Latest Stable Version](https://poser.pugx.org/olajoscs/querybuilder/v/stable)](https://packagist.org/packages/olajoscs/querybuilder)
# QueryBuilder
A simple query builder for relational databases, currently with MySQL and PostgreSQL support. 100% of the code is unit tested.

Contains the 4 basic (CRUD) operations with transaction handling.

Minimum requirements: PHP 5.5+ with MySQL or PostgreSQL.

# Creating the connection
The Connection class extends the built-in PDO class. It is the starting point of creating statements.
Create a new instance based on the database type you are using, and give it to your DI container trait it as a singleton.
The constructor is the same as the one in the PDO class.

```php
  $myDIContainer->singleton('connection', function() {
    return new OlajosCs\QueryBuilder\MySQL\Connection($type, $host, $username, $password, $database, $options)
  });
```

# Starting from Connection
There are 4 statements (Select, Update, Insert, Delete), which have own methods to create.
All the statements has an execute method, which executes the built query, then returns the PDOStatement object.

## Transaction
Transaction can be used with a callback function. In case of any exception all changes are rollbacked.
```php
  $connection->transaction(function() use ($connection) {
    $connection->get(...);
  });
```

## Basic select syntax
The syntax of building a select statmenet is similar to do it in SQL.
```php
  $connection
    ->select(['field', 'list'])
    ->from('table_name')
    ->where('field', '=', $value)
    ->groupBy('field')
    ->orderBy('field')
    ->get();
```

### List of get.... methods
- get(): Returns an array of stdClasses.

- getAsClasses(string $className, array $constructorParameter): Returns an array of explicit object.

- getOne(): Returns only one stdClass. If multiple rows would be returned, or there are no rows to return, it throws exception.

- getOneClass(string $className, array $constructorParameter): Returns only one explicit object. If multiple rows would be returned, or there are no rows to return, it throws exception.

- getOneField(string $fieldName): Returns only one field of the row. If the field is not found, exception is thrown.

- getList(string $fieldName): Returns a list of the specified field from the rows. IF the field is not found, exception is thrown.

- getWithKey(string $keyField): Returns the an array of stdClasses. The key of the elements are the current value of the $keyField variable.

- getClassesWithKey(string $className, array $constructorParameters, string $keyField): Returns an array of explicit objects. The key of the elements are the current value of the $keyField variable.

## Basic update syntax
Update syntax is similar as seen in SQL.

The query is executed only when the execute() method is called.
```php
  $connection
    ->update('table_name')
    ->set(
      [
        'value1' => 1,
        'value2' => 2
      ]
    )
    ->where('id', '=', 1)
    ->execute();
```

## Basic insert syntax
Insert syntax is similar as seen in SQL.

The query is executed only when the execute() method is called.
```php
  $connection
    ->insert(
      [
        'field1' => 1,
        'field2' => 2
      ]
    )
    ->into('table_name')
    ->execute();  
  // OR
  $connection
    ->insert()  
    ->into('table_name')
    ->values(  
      [
        'field1' => 1,
        'field2' => 2
      ]
    )
    ->execute();  
```

## Basic delete syntax
Delete syntax is similar as seen in SQL.

The query is executed only when the execute() method is called.
```php
  $connection
    ->delete()
    ->from('table_name')
    ->where('id', '=', 1)
    ->execute();
```

## Raw expressions
RawExpression object can be used when any expression is needed, but the querybuilder is not able to handle it.
This can be used in select and where methods.

```php
  // for MySQL
  $connection
    ->select($connection->createRawExpression('count(1) as counter'))
    ->from('tests')
    ->getOneField('counter');

  $connection
    ->select() // empty means *
    ->from('tests')
    ->where($connection->createRawExpression('select count....... = 1')
    ->get();
```

## Where clauses
In Select, Update and Delete statements where clauses can be used.
All these statements have the following methods regarding where either with "and" connector (normal methods) or "or" connector, with a where...Or method.

### Where... methods
- where(string $field, string $operator, mixed $value): Basic where, field {<>!=} value.
- whereIn(string $field, array $values): Where field in (value1, value2).
- whereNotIn(string $field, array $values): Where field not in (value1, value2).
- whereBetween(string $field, mixed $min, mixed $max): Where field between min and max.
- whereNull(string $field): Where field is null.
- whereNotNull(string $field): Where field is not null.
- whereRaw(RawExpression('where ...')): Where clause is placed directly into the query.

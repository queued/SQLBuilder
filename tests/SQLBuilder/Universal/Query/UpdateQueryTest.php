<?php
use SQLBuilder\Raw;
use SQLBuilder\Universal\Query\UpdateQuery;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Driver\PgSQLDriver;
use SQLBuilder\Driver\SQLiteDriver;
use SQLBuilder\ToSqlInterface;
use SQLBuilder\ArgumentArray;
use SQLBuilder\ParamMarker;
use SQLBuilder\Bind;

class UpdateQueryTest extends PHPUnit_Framework_TestCase
{
    public function testBasicUpdate()
    {
        $driver = new MySQLDriver;
        $args = new ArgumentArray;
        $query = new UpdateQuery;
        $query->update('users')->set([ 
            'name' => 'Mary'
        ]);
        $query->where()
            ->equal('id', 3);
        ok($query);
        $sql = $query->toSql($driver, $args);
        is('UPDATE users SET name = :name WHERE id = 3', $sql);
    }


    public function testBasicUpdateWithBind()
    {
        $driver = new MySQLDriver;
        $args = new ArgumentArray;
        $query = new UpdateQuery;
        $query->options('LOW_PRIORITY', 'IGNORE')->update('users')->set([ 
            'name' => new Bind('nameA','Mary'),
        ]);
        $query->where()
            ->equal('id', new Bind('id', 3));
        ok($query);
        $sql = $query->toSql($driver, $args);
        is('UPDATE LOW_PRIORITY IGNORE users SET name = :nameA WHERE id = :id', $sql);
    }

    public function testBasicUpdateWithParamMarker()
    {
        $driver = new MySQLDriver;
        $args = new ArgumentArray;
        $query = new UpdateQuery;
        $query->options('LOW_PRIORITY', 'IGNORE')->update('users')->set([ 
            'name' => new ParamMarker('Mary'),
        ]);
        $query->where()
            ->equal('id', new ParamMarker(3));
        ok($query);
        $sql = $query->toSql($driver, $args);
        is('UPDATE LOW_PRIORITY IGNORE users SET name = ? WHERE id = ?', $sql);
    }


}


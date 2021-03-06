<?php
namespace SQLBuilder\Universal\Query;
use SQLBuilder\ToSqlInterface;
use SQLBuilder\ArgumentArray;
use SQLBuilder\Driver\BaseDriver;
use SQLBuilder\Driver\SQLiteDriver;
use SQLBuilder\Driver\MySQLDriver;
use SQLBuilder\Driver\PgSQLDriver;
use SQLBuilder\Universal\Syntax\Column;
use SQLBuilder\Universal\Syntax\Constraint;


/**
 * MySQL Create Table Syntax
 *
 * @see http://dev.mysql.com/doc/refman/5.0/en/create-table.html
 */
class CreateTableQuery implements ToSqlInterface
{
    protected $tableName;

    protected $engine;

    protected $constraints = array();

    protected $columns = array();

    public function __construct($tableName) {
        $this->tableName = $tableName;
    }

    public function table($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function engine($engine)
    {
        $this->engine = $engine;
        return $this;
    }

    public function column($name) {
        $col = new Column($name);
        $this->columns[] = $col;
        return $col;
    }

    public function constraint($name) {
        $this->constraints[] = $constraint = new Constraint($name, $this);
        return $constraint;
    }

    public function toSql(BaseDriver $driver, ArgumentArray $args) 
    {
        $sql = "CREATE TABLE " . $driver->quoteIdentifier($this->tableName);
        $sql .= "(";
        $columnClauses = array();
        foreach($this->columns as $col) {
            $sql .= "\n" . $col->toSql($driver, $args) . ",";
        }

        if ($this->constraints) {
            foreach($this->constraints as $constraint) {
                $sql .= "\n" . $constraint->toSql($driver, $args) . ",";
            }
        }

        $sql = rtrim($sql,',') . "\n)";

        if ($this->engine && $driver instanceof MySQLDriver) {
            $sql .= ' ENGINE=' . $this->engine;
        }
        return $sql;
    }
}





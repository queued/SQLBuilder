<?php
namespace SQLBuilder\Universal\Expr;
use SQLBuilder\Universal\Expr\Expr;
use SQLBuilder\Universal\Expr\ListExpr;
use SQLBuilder\Driver\BaseDriver;
use SQLBuilder\ToSqlInterface;
use SQLBuilder\ArgumentArray;

class InExpr implements ToSqlInterface { 

    public $exprStr;

    public $listExpr;

    public function __construct($exprStr, $expr)
    {
        $this->exprStr = $exprStr;
        $this->listExpr = new ListExpr($expr);
    }

    public function toSql(BaseDriver $driver, ArgumentArray $args) {
        return $this->exprStr . ' IN ' . $this->listExpr->toSql($driver, $args);
    }
}

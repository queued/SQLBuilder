<?php
namespace SQLBuilder\Universal\Traits;
use SQLBuilder\Driver\BaseDriver;
use SQLBuilder\ArgumentArray;

trait IfExistsTrait
{
    protected $ifExists = false;

    public function ifExists() {
        $this->ifExists = true;
        return $this;
    }

    public function buildIfExistsClause() {
        if ($this->ifExists) {
            return ' IF EXISTS';
        }
        return '';
    }

}




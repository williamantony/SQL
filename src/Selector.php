<?php

namespace WA\SQL;

use WA\SQL\Traits\{CommonTrait, Where};

class Selector
{
    private $query;
    private $tablename;
    private $columns;
    
    use Where;
    use CommonTrait;

    public function table(string $tablename = null)
    {
        if (is_string($tablename))
            $this->tablename = $tablename;

        return $this;
    }

    public function select(array $columns = null)
    {
        $this->columns = "*";

        if (is_array($columns))
            $this->columns = "`" . implode("`, `", $columns) . "`";

        return $this;
    }

    public function getQuery()
    {
        $tablename = $this->tablename;
        $columns = isset($this->columns) ? $this->columns : "*";
        $where = $this->getWherePart();
        
        $query = "SELECT $columns FROM `$tablename`" . $where . ";";

        $this->query = $query;

        return $query;
    }
}

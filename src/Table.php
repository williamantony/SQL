<?php

namespace WA\SQL;

use WA\SQL\Column;
use WA\SQL\Traits\{CommonTrait, Constraints};

class Table
{
    private $query;
    private $tablename;
    private $columns = array();
    
    use CommonTrait;
    use Constraints;

    public function __construct(string $tablename)
    {
        $this->name($tablename);
    }

    public function name(string $tablename = null)
    {
        if (is_string($tablename))
            $this->tablename = $tablename;

        return $this;
    }

    public function column(string $column)
    {
        if (array_key_exists($column, $this->columns))
            return $this->columns[$column];

        $this->columns[$column] = new Column($column);
        return $this->columns[$column];
    }

    private function getColumnsQuery()
    {
        $queries = array();

        foreach ($this->columns as $name => $column) {
            array_push($queries, "\n".$column->getQuery());
        }

        return implode(", ", $queries);
    }

    public function getQuery()
    {
        $columns = $this->getColumnsQuery() . "\n";

        $this->query = "CREATE TABLE IF NOT EXISTS `" . $this->tablename . "` ( "
            . $columns . " ) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_general_ci;";

        $this->query .= "\n".implode("\n", $this->constraints);

        return $this->query;
    }
}

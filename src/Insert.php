<?php

namespace WA\SQL;

use WA\SQL\Traits\CommonTrait;

class Insert
{
    private $query;
    private $tablename;
    private $values;

    use CommonTrait;

    public function __construct(array $values = null)
    {
        $this->values($values);
    }

    public function table(string $tablename = null)
    {
        if (is_string($tablename))
            $this->tablename = $tablename;

        return $this;
    }

    public function into(string $tablename = null)
    {
        return $this->table($tablename);
    }

    public function values(array $values = null)
    {
        if (is_array($values))
        {
            $names = "`" . implode("`, `", array_keys($values)) . "`";
            $values = "'" . implode("', '", array_values($values)) . "'";

            $this->values = "(" . $names . ") VALUES (" . $values . ")";
        }

        return $this;
    }

    public function getQuery()
    {
        $query = "INSERT INTO `" . $this->tablename . "` " . $this->values . ";";

        $this->query = $query;

        return $query;
    }
}

<?php

namespace WA\SQL;

use WA\SQL\Traits\{CommonTrait, Where};

class Update
{
    private $query;
    private $tablename;
    private $values;

    use Where;
    use CommonTrait;

    public function __construct(string $tablename = null)
    {
        $this->table($tablename);
    }

    public function table(string $tablename = null)
    {
        if (is_string($tablename))
            $this->tablename = $tablename;

        return $this;
    }

    public function values(array $values = null)
    {
        if (is_array($values))
        {
            $set = array();

            foreach ($values as $key => $value) {
                $part = "`" . $key . "` = '" . $value . "'";
                array_push($set, $part);
            }

            $this->values = implode(", ", $set);
        }

        return $this;
    }

    public function with(array $values = null)
    {
        return $this->values($values);
    }

    public function getQuery()
    {
        $where = $this->getWherePart();

        $query = "UPDATE `" . $this->tablename . "` SET " . $this->values . $where . ";";

        $this->query = $query;

        return $query;
    }
}

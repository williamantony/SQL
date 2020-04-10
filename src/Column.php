<?php

namespace WA\SQL;

use WA\SQL\Traits\FormatHelpers;

class Column
{
    private $query;

    private $name;
    private $type;
    private $size;

    private $default = "DEFAULT NULL";
    private $nullable = "NULL";
    private $autoIncrement;
    private $constraint;

    use FormatHelpers;

    public function __construct(string $name)
    {
        $this->name($name);
    }

    public function name(string $name)
    {
        if (isset($name))
            $this->name = $name;

        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function size(int $size)
    {
        $this->size = $size;
        return $this;
    }

    public function default($value, $quote = true)
    {
        $quote = $quote ? "'" : "";

        $value = is_null($value) ? "NULL" : $value;
        $value = (is_string($value) || is_int($value)) ? $quote . $value . $quote : false;

        if ($value)
            $this->default = "DEFAULT " . $value;

        return $this;
    }

    public function nullable(bool $nullable = true)
    {
        $this->nullable = $nullable ? "NULL" : "NOT NULL";
        $this->default = $nullable ? "DEFAULT NULL" : null;
            
        return $this;
    }

    public function autoIncrement(bool $autoIncrement = true)
    {
        if (strtolower($this->type) === "int")
            $this->autoIncrement = "AUTO_INCREMENT";

        return $this;
    }

    public function unique(bool $isUnique = true)
    {
        if ($this->constraint !== "PRIMARY")
            $this->constraint = $isUnique ? "UNIQUE" : "";

        return $this;
    }

    public function primary(bool $isPrimary = true)
    {
        $this->constraint = $isPrimary ? "PRIMARY" : "";
        return $this;
    }

    public function getQuery()
    {
        $name = "`" . $this->name . "`";
        $size = isset($this->size) ? "(" . $this->size . ")" : "";
        $datatype = $this->type . $size;
        
        $query = $name;
        $this->concat($query, $datatype);
        $this->concat($query, $this->nullable);
        $this->concat($query, $this->default);
        $this->concat($query, $this->autoIncrement);
        $this->concat($query, $this->constraint);

        $this->query = $query;
        return $this->query;
    }
}

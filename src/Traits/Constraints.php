<?php

namespace WA\SQL\Traits;

trait Constraints
{
    private $constraints = array();

    use ConstraintsParts;

    public function primary($columns, string $constraint_name = null)
    {
        $query = $this->part_alterTable();
        $query .= "ADD ";
        $query .= $this->part_constraint($constraint_name);
        $query .= "PRIMARY KEY ";
        $query .= $this->part_columns($columns);
        $query .= ";";

        array_push($this->constraints, $query);

        return $this;
    }

    public function foreign(string $fcolumn, string $ptable, string $pcolumn, string $constraint_name = null)
    {
        $query = $this->part_alterTable();
        $query .= "ADD ";
        $query .= $this->part_constraint($constraint_name);
        $query .= "FOREIGN KEY ";
        $query .= $this->part_columns($fcolumn);
        $query .= " REFERENCES ";
        $query .= "`" . $ptable . "`";
        $query .= $this->part_columns($pcolumn);
        $query .= ";";
        
        array_push($this->constraints, $query);

        return $this;
    }

    public function unique($columns, string $constraint_name = null)
    {
        $query = $this->part_alterTable();
        $query .= "ADD ";
        $query .= $this->part_constraint($constraint_name);
        $query .= "UNIQUE ";
        $query .= $this->part_columns($columns);
        $query .= ";";

        array_push($this->constraints, $query);

        return $this;
    }

    public function index($columns, string $constraint_name)
    {
        $query = $this->part_createIndex($constraint_name);
        $query .= $this->part_columns($columns);
        $query .= ";";

        array_push($this->constraints, $query);

        return $this;
    }

}

<?php

namespace WA\SQL\Traits;

trait ConstraintsParts
{
    public function part_alterTable()
    {
        return "ALTER TABLE `" . $this->tablename . "` ";
    }

    public function part_createIndex(string $constraint_name)
    {
        return "CREATE INDEX `$constraint_name` ON `" . $this->tablename . "` ";
    }

    public function part_constraint(string $constraint_name = null)
    {
        if (is_string($constraint_name))
            return "CONSTRAINT `$constraint_name` ";

        return "";
    }

    public function part_columns($columns)
    {
        if (is_string($columns))
            return "(`" . $columns . "`)";
        
        if (is_array($columns))
            return "(`" . implode("`, `", $columns) . "`)";

        return "";
    }
}

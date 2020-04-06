<?php

namespace WA\SQL\Traits;

trait Where
{
    private $where;
    private $limit;
    private $order;

    public function limit(int $limit = null)
    {
        if (is_numeric($limit))
            $this->limit = $limit;

        return $this;
    }

    public function order(string $column = null, string $type = "ASC")
    {
        if (is_string($column))
            $this->order = $this->order . (empty($this->order) ? "" : ", ") . "`$column` $type";

        return $this;
    }

    public function where(array $where = null, string $operator = "=", string $glue = "AND")
    {
        if (is_array($where) && !empty($where))
        {
            $whereString = "";

            foreach ($where as $key => $value) {
                $whereString .= empty($whereString) ? "" : " $glue ";
                $whereString .= "`$key` $operator '$value'";
            }

            $this->where .= empty($this->where) ? "" : " $glue ";
            $this->where .= (count($where) > 1) ? "( $whereString )" : $whereString;
        }

        return $this;
    }

    public function whereLike(array $where = null, string $likeOperator = "%-%", string $glue = "AND")
    {
        if (is_array($where) && !empty($where))
        {
            foreach ($where as $key => $value) {
                $replaced = preg_replace("/\-/i", $value, $likeOperator);
                $where[$key] = $replaced;
            }
            
            return $this->where($where, "LIKE");
        }

        return $this;
    }

    public function andWhere(array $where = null, string $operator = "=")
    {
        return $this->where($where, $operator, "AND");
    }

    public function orWhere(array $where = null, string $operator = "=")
    {
        return $this->where($where, $operator, "OR");
    }

    private function getWherePart()
    {
        $where = isset($this->where) ? " WHERE " . $this->where : " WHERE 1";
        $limit = isset($this->limit) ? " LIMIT " . $this->limit : "";
        $order = isset($this->order) ? " ORDER BY " . $this->order : "";
        
        $query = $where . $order . $limit;

        return $query;
    }
}
<?php

namespace WA\SQL\Traits;

trait CommonTrait
{
    public function clear(array $except = [])
    {
        $properties = array( "query", "tablename", "columns", "where", "limit", "order" );

        foreach ($properties as $property_name) {
            if (!in_array($property_name, $except))
                $this->$property_name = null;
        }

        return $this;
    }
}

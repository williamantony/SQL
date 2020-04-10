<?php

namespace WA\SQL\Traits;

trait FormatHelpers
{
    private function concat(string &$query, $part)
    {
        if (!empty($query) && !empty($part))
            $query .= " ";

        $query .= $part;
    }
}

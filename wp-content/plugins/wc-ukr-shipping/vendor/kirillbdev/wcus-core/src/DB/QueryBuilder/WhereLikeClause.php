<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class WhereLikeClause extends BaseWhereClause
{
    /**
     * @param string $column
     * @param string $value
     */
    public function __construct($column, $value, $prefix)
    {
        parent::__construct($column, $value, 'like', $prefix);
    }

    public function substituteValue()
    {
        return '%s';
    }
}
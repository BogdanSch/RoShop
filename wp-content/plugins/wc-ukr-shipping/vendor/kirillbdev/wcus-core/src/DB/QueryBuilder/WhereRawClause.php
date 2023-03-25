<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

class WhereRawClause implements ClauseInterface
{
    /**
     * @var string
     */
    private $sql;

    /**
     * @var array
     */
    private $values;

    /**
     * @var string
     */
    private $prefix;

    public function __construct($sql, $values, $prefix)
    {
        $this->sql = $sql;
        $this->values = $values;
        $this->prefix = $prefix;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function getBindings()
    {
        return $this->values;
    }
}
<?php

namespace MatheusSouzaJose\DataMapperOrm\QueryBuilder;

use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Filters\Where;

class Delete implements IQueryBuilder
{
    use Where;

    /** @var string */
    private string $query;

    /** @var array */
    protected array $values = [];

    /**
     * @param string $table
     * @param array $conditions
     */
    public function __construct(string $table, array $conditions = [])
    {
        $this->query = $this->makeSql($table, $conditions);
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return string
     */
    private function makeSql(string $table, array $conditions): string
    {
        $sql = sprintf('DELETE FROM %s', $table);
        if ($conditions) {
            $sql .= $this->makeWhere($conditions);
        }

        return $sql;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->query;
    }
}

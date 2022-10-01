<?php

namespace MatheusSouzaJose\DataMapperOrm\QueryBuilder;

use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Filters\Where;

class Update implements IQueryBuilder
{
    use Where;

    /** @var string */
    private string $query;

    /** @var array */
    protected array $values = [];

    /**
     * @param string $table
     * @param array $data
     * @param array $conditions
     */
    public function __construct(string $table, array $data, array $conditions = [])
    {
        $this->values = array_values($data);
        $this->query = $this->makeSql($table, $data, $conditions);
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $conditions
     * @return string
     */
    private function makeSql(string $table, array $data, array $conditions): string
    {
        $sql = sprintf('UPDATE %s', $table);

        $columns = array_keys($data);
        $columns_query = [];
        foreach ($columns as $column) {
            $columns_query[] = $column . '=?';
        }

        $sql .= ' SET ' . implode(', ', $columns_query);

        $sql .= $this->makeWhere($conditions);

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

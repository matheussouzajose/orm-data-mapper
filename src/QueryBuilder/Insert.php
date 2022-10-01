<?php

namespace MatheusSouzaJose\DataMapperOrm\QueryBuilder;

use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Filters\Where;

class Insert implements IQueryBuilder
{
    use Where;

    /** @var string */
    private string $query;

    /** @var array|mixed */
    protected array $values = [];

    /**
     * @param string $table
     * @param array $data
     */
    public function __construct(string $table, array $data = [])
    {
        $this->query = $this->makeSql($table, $data);
        $this->values = array_values($data);
    }

    /**
     * @param string $table
     * @param array $data
     * @return string
     */
    private function makeSql(string $table, array $data): string
    {
        $sql = sprintf('INSERT INTO %s', $table);

        $columns = array_keys($data);
        $values = array_fill(0, count($data), '?');

        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        $sql .= sprintf(' (%s) VALUES (%s)', $columns, $values);
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

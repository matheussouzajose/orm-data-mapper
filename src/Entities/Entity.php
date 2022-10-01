<?php

namespace MatheusSouzaJose\DataMapperOrm\Entities;

class Entity implements IEntity
{
    /** @var array */
    protected array $data;

    /** @var string */
    protected string $table;

    /** @param array $data */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setAll(array $data): Entity
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        if (!empty($this->table)) {
            return $this->table;
        }

        $table = get_class($this);
        $table = explode('\\', $table);
        $table = array_pop($table);

        return strtolower($table);
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $method = $this->methodName('set', $name);
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $method = $this->methodName('get', $name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return $this->data[$name];
    }

    /**
     * @param $prefix
     * @param $name
     * @return string
     */
    private function methodName($prefix, $name): string
    {
        $method = str_replace('_', ' ', $name);
        $method = ucwords($method);
        $method = str_replace(' ', '', $method);

        return $prefix . $method;
    }
}

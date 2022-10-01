<?php

namespace MatheusSouzaJose\DataMapperOrm\Repositories;

use http\Exception\InvalidArgumentException;
use MatheusSouzaJose\DataMapperOrm\Drivers\IDriver;
use MatheusSouzaJose\DataMapperOrm\Entities\IEntity;
use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Delete;
use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Insert;
use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Select;
use MatheusSouzaJose\DataMapperOrm\QueryBuilder\Update;
use PHPUnit\Util\Exception;

class Repository implements IRepository
{
    /** @var IDriver */
    protected IDriver $driver;

    /** @var */
    protected $entity;

    /**
     * @param IDriver $driver
     */
    public function __construct(IDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @throws \ReflectionException
     */
    public function setEntity(string $entity)
    {
        $reflection = new \ReflectionClass($entity);
        if (!$reflection->implementsInterface(IEntity::class)) {
            throw new InvalidArgumentException("{$entity} not implements interface " . IEntity::class);
        }
        $this->entity = $entity;
    }

    /**
     * @return IEntity
     */
    public function getEntity(): IEntity
    {
        if (is_null($this->entity)) {
            throw new Exception('entity is required');
        }

        if (is_string($this->entity)) {
            return new $this->entity;
        }
    }

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function insert(IEntity $entity): IEntity
    {
        $this->driver->setQueryBuilder(new Insert($entity->getTable(), $entity->getAll()));
        $this->driver->execute();

        return $this->first($this->driver->lastInsertedId());
    }

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function update(IEntity $entity): IEntity
    {
        $condition = [
            ['id', $entity->id]
        ];

        $this->driver->setQueryBuilder(new Update($entity->getTable(), $entity->getAll(), $condition));
        $this->driver->execute();

        return $entity;

    }

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function delete(IEntity $entity): IEntity
    {
        $condition = [
            ['id', $entity->id]
        ];

        $this->driver->setQueryBuilder(new Delete($entity->getTable(), $condition));
        $this->driver->execute();

        return $entity;

    }

    /**
     * @param $id
     * @return IEntity|null
     */
    public function first($id = null): ?IEntity
    {
        $entity = $this->getEntity();
        $table = $entity->getTable();

        $conditions = [];

        if (!is_null($id)) {
            $conditions[] = ['id', $id];
        }

        $this->driver->setQueryBuilder(new Select($table, $conditions));
        $this->driver->execute();
        $data = $this->driver->first();

        if (!$data) {
            return null;
        }

        return $entity->setAll($data);
    }

    /**
     * @param array $condition
     * @return array
     */
    public function all(array $condition = []): array
    {
        $entity = $this->getEntity();
        $table = $entity->getTable();

        $this->driver->setQueryBuilder(new Select($table, $condition));
        $this->driver->execute();

        $data = $this->driver->all();

        $entities = [];
        foreach ($data as $row) {
            $entities[] = new $this->entity($row);
        }
        return $entities;
    }
}

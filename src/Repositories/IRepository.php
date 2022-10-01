<?php

namespace MatheusSouzaJose\DataMapperOrm\Repositories;

use MatheusSouzaJose\DataMapperOrm\Drivers\IDriver;
use MatheusSouzaJose\DataMapperOrm\Entities\IEntity;

interface IRepository
{
    /**
     * @param IDriver $driver
     */
    public function __construct(IDriver $driver);

    /**
     * @param string $entity
     * @return mixed
     */
    public function setEntity(string $entity);

    /**
     * @return IEntity
     */
    public function getEntity(): IEntity;

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function insert(IEntity $entity): IEntity;

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function update(IEntity $entity): IEntity;

    /**
     * @param IEntity $entity
     * @return IEntity
     */
    public function delete(IEntity $entity): IEntity;

    /**
     * @param $id
     * @return IEntity|null
     */
    public function first($id = null): ?IEntity;

    /**
     * @param array $condition
     * @return array
     */
    public function all(array $condition = []): array;
}

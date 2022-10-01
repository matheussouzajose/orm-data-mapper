<?php

namespace MatheusSouzaJose\DataMapperOrm\Entities;

interface IEntity
{
    /**
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * @param array $data
     * @return mixed
     */
    public function setAll(array $data);

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @return string
     */
    public function getTable(): string;
}

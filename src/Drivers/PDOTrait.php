<?php

namespace MatheusSouzaJose\DataMapperOrm\Drivers;

use MatheusSouzaJose\DataMapperOrm\QueryBuilder\IQueryBuilder;
use PDO;

trait PDOTrait
{
    /** @var array|string[] */
    protected static array $requiredArguments = ['server', 'database', 'user'];

    /** @var PDO|null */
    protected ?PDO $pdo;

    /** @var IQueryBuilder */
    protected IQueryBuilder $queryBuilder;

    /** @var */
    protected $sth;

    /**
     * @param array $config
     * @return void
     */
    public function connect(array $config)
    {
        $this->validArgument($config);

        $dsn = sprintf($this->dsn_pattern, $config['server'], $config['database']);
        $user = $config['user'];
        $password = $config['password'] ?? null;
        $options = $config['options'] ?? [];

        $this->pdo = new PDO($dsn, $user, $password, $options);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return void
     */
    public function close()
    {
        $this->pdo = null;
    }

    /**
     * @param IQueryBuilder $queryBuilder
     * @return void
     */
    public function setQueryBuilder(IQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        $this->sth = $this->pdo->prepare((string)$this->queryBuilder);
        return $this->sth->execute($this->queryBuilder->getValues());
    }

    /**
     * @return false|string
     */
    public function lastInsertedId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $config
     * @return void
     */
    private function validArgument(array $config)
    {
        foreach (self::$requiredArguments as $argument) {
            if (empty($config[$argument])) {
                throw new \InvalidArgumentException(" {$argument} is required");
            }
        }
    }
}

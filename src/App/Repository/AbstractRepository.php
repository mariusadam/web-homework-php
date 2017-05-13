<?php

namespace App\Repository;

use App\Services\EntityBuilder;
use App\Services\EntityMapper;
use App\Services\Utils;
use Doctrine\DBAL\Connection;


/**
 * Class AbstractRepository
 *
 * @package App\Repository
 *
 * @author  Marius Adam
 */
abstract
class AbstractRepository
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var EntityBuilder
     */
    private $entityBuilder;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * AbstractRepository constructor.
     *
     * @param Connection    $connection
     * @param EntityBuilder $entityBuilder
     * @param               $entityClass
     */
    public function __construct(Connection $connection, EntityBuilder $entityBuilder, $entityClass)
    {
        $this->connection = $connection;
        $this->entityBuilder = $entityBuilder;
        $this->entityClass = $entityClass;
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function findBy(int $id)
    {
        $qb = $this->connection->createQueryBuilder();
        $stmt = $qb->select('*')
                   ->from($this->getEntityTable(), 't')
                   ->where('t.id = :id')
                   ->setParameter('id', $id)
                   ->execute();

        $rows = $stmt->fetchAll();
        if (count($rows) != 1) {
            throw new \Exception(
                "Could not fond one {$this->entityClass} with id {$id}."
            );
        }

        return $this->entityBuilder->build($rows[0], $this->entityClass);
    }

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $entityData = EntityMapper::toArray($entity);
        if ($this->isUpdate($entityData)) {
            $this->update($entityData);
        } else {
            $this->insert($entityData);
        }
    }

    /**
     * @param mixed $entity Entity object or it's id
     *
     * @return int
     */
    public function delete($entity)
    {
        $id = null;
        if (is_numeric($entity)) {
            $id = $entity;
        } else {
            $id = $entity->{'getId'}();
        }

        return $this->connection->delete(
            $this->getEntityTable(),
            ['id' => $id]
        );
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $toEntity = function ($row) {
            return $this->entityBuilder->build($row, $this->entityClass);
        };

        return array_map(
            $toEntity,
            $this->connection
                ->createQueryBuilder()
                ->select('*')
                ->from($this->getEntityTable())
                ->execute()
                ->fetchAll()
        );
    }

    /**
     * @return int[]
     */
    public function getAllIds(): array
    {
        $ids = $this->connection
            ->createQueryBuilder()
            ->select('t.id')
            ->from($this->getEntityTable(), 't')
            ->execute()
            ->fetchAll();
        $ids = array_column($ids, 'id');

        return array_combine($ids, $ids);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    protected function isUpdate(array $data): bool
    {
        return array_key_exists('id', $data);
    }

    /**
     * @param array $data
     *
     * @return int
     */
    protected function update(array $data)
    {
        $id = $data['id'];
        unset($data['id']);

        return $this->connection->update(
            $this->getEntityTable(),
            $data,
            ['id' => $id]
        );
    }

    /**
     * @param array $data
     *
     * @return int
     */
    protected function insert(array $data)
    {
        return $this->connection->insert(
            $this->getEntityTable(),
            $data
        );
    }

    /**
     * @return string
     */
    protected abstract function getEntityTable(): string;
}

<?php

namespace App\Repository;

use App\Entity\User;
use App\Services\EntityBuilder;
use Doctrine\DBAL\Connection;


/**
 * Class UserRepository
 *
 * @package App\Repository
 *
 * @author  Marius Adam
 */
class UserRepository extends AbstractRepository
{
    public function __construct(Connection $connection, EntityBuilder $entityBuilder)
    {
        parent::__construct($connection, $entityBuilder, User::class);
    }


    /**
     * @param int $id
     *
     * @return User
     */
    public function findBy(int $id)
    {
        return parent::findBy($id);
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        return parent::getAll(); // TODO: Change the autogenerated stub
    }


    /**
     * @inheritdoc
     */
    protected function getEntityTable(): string
    {
        return 'users';
    }

    /**
     * @param $text
     *
     * @return User[]
     */
    public function search($text)
    {
        $text = "%{$text}%";

        return array_map(
            [$this, 'toEntity'],
            $this->connection
                ->createQueryBuilder()
                ->select('*')
                ->from($this->getEntityTable())
                ->where('username like :u')
                ->orWhere('email like :e')
                ->setParameter('u', $text)
                ->setParameter('e', $text)
                ->execute()
                ->fetchAll()
        );
    }

    /**
     * @param $username
     *
     * @return User
     * @throws \Exception
     */
    public function findByUsername($username)
    {
        $user = $this->toEntity(
            $this->connection
                ->createQueryBuilder()
                ->select('*')
                ->from($this->getEntityTable())
                ->where('username = :username')
                ->orWhere('email = :email')
                ->setMaxResults(1)
                ->setParameter('username', $username)
                ->setParameter('email', $username)
                ->execute()
                ->fetch()
        );
        if ($user == null) {
            throw new \Exception("Could not find the user '{$username}'");
        }

        return $user;
    }
}
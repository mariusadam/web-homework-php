<?php

namespace App\Repository;

use App\Entity\FootballTeam;
use App\Services\EntityBuilder;
use Doctrine\DBAL\Connection;


/**
 * Class FootballTeamRepository
 *
 * @package App\Repository
 *
 * @author  Marius Adam
 */
class FootballTeamRepository extends AbstractRepository
{
    /**
     * FootballTeamRepository constructor.
     *
     * @param Connection    $connection
     * @param EntityBuilder $entityBuilder
     */
    public function __construct(Connection $connection, EntityBuilder $entityBuilder)
    {
        parent::__construct($connection, $entityBuilder, FootballTeam::class);
    }

    /**
     * @param int $id
     *
     * @return FootballTeam
     */
    public function findBy(int $id)
    {
        return parent::findBy($id);
    }

    /**
     * @return FootballTeam[]
     */
    public function getAll(): array
    {
        return parent::getAll();
    }

    /**
     * {@inheritDoc}
     */
    protected function getEntityTable(): string
    {
        return 'football_teams';
    }
}

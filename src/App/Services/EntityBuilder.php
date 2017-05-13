<?php

namespace App\Services;

use App\Entity\FootballTeam;


/**
 * Class EntityBuilder
 *
 * @package App\Services
 *
 * @author  Marius Adam
 */
class EntityBuilder
{
    /**
     * @const
     */
    const ENTITY_NAMESPACE = 'App\\Entity\\';

    /**
     * @param array $data
     *
     * @return FootballTeam
     */
    public function buildFootBallTeam(array $data): FootballTeam
    {
        return $this->build($data, FootballTeam::class);
    }

    /**
     * @param array  $data
     * @param string $class
     *
     * @return mixed
     */
    public function build(array $data, string $class)
    {
        $entity = new $class();
        foreach ($data as $property => $value) {
            if (strpos($property, '_id') !== false) {
                $value = $this->build($value, $this->getEntityClass($property));
                $property = str_replace('_id', '', $property);
            }
            $setter = 'set'.Utils::snakeToPascalCase($property);
            $entity->{$setter}($value);
        }

        return $entity;
    }

    protected function getEntityClass($referencedName)
    {
        $shortName = str_replace('_id', '', $referencedName);

        return self::ENTITY_NAMESPACE.Utils::snakeToPascalCase($shortName);
    }
}
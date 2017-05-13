<?php

namespace App\Entity;

/**
 * Class Entity
 *
 * @package App\Entity
 *
 * @author  Marius Adam
 */
abstract class Entity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}

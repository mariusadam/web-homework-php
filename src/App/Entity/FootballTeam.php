<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class FootballTeam
 *
 * @package App\Entity
 *
 * @author  Marius Adam
 */
class FootballTeam extends Entity
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="30")
     *
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    private $playedGames;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    private $wonGames;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    private $lostGames;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    private $scoredGoals;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var float
     */
    private $score;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPlayedGames()
    {
        return $this->playedGames;
    }

    /**
     * @param int $playedGames
     */
    public function setPlayedGames($playedGames)
    {
        $this->playedGames = $playedGames;
    }

    /**
     * @return int
     */
    public function getWonGames()
    {
        return $this->wonGames;
    }

    /**
     * @param int $wonGames
     */
    public function setWonGames($wonGames)
    {
        $this->wonGames = $wonGames;
    }

    /**
     * @return int
     */
    public function getLostGames()
    {
        return $this->lostGames;
    }

    /**
     * @param int $lostGames
     */
    public function setLostGames($lostGames)
    {
        $this->lostGames = $lostGames;
    }

    /**
     * @return int
     */
    public function getScoredGoals()
    {
        return $this->scoredGoals;
    }

    /**
     * @param int $scoredGoals
     */
    public function setScoredGoals($scoredGoals)
    {
        $this->scoredGoals = $scoredGoals;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }
}

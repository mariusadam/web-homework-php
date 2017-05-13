<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170513123232 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            <<<SQL
        CREATE TABLE football_teams (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        played_games INT NOT NULL,
        won_games INT NOT NULL,
        lost_games INT NOT NULL,
        scored_goals INT NOT NULL,
        score FLOAT NOT NULL 
);
SQL
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE IF EXISTS football_teams');

    }
}

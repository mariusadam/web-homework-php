<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170513131228 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            "INSERT INTO `football_teams` 
                (`id`, `name`, `played_games`, `won_games`, `lost_games`, `scored_goals`, `score`) 
            VALUES 
                ('1', 'FC Lopata', '112', '12', '100', '14', '5.6'),
                ('2', 'FC Steaua', '32', '9', '25', '5', '5.6'),
                ('3', 'FC Rapid', '23', '8', '15', '8', '5.6'),
                ('4', 'FC UCJ', '32', '10', '22', '3', '5.6'),
                ('5', 'CFR', '12', '3', '9', '3', '5.6')
                "
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM `football_teams` WHERE `football_teams`.`id` = 1");
        $this->addSql("DELETE FROM `football_teams` WHERE `football_teams`.`id` = 2");
        $this->addSql("DELETE FROM `football_teams` WHERE `football_teams`.`id` = 3");
        $this->addSql("DELETE FROM `football_teams` WHERE `football_teams`.`id` = 4");
        $this->addSql("DELETE FROM `football_teams` WHERE `football_teams`.`id` = 5");
    }
}

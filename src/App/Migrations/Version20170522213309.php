<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170522213309 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            <<<SQL
        CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        role VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(128) NOT NULL,
        age INT NOT NULL,
        email VARCHAR(50) NOT NULL,
        web_page VARCHAR(255) NOT NULL
);
SQL
        );

        $this->addSql(
            <<<'SQL'
        INSERT INTO `users` 
        (`id`, `name`, `role`, `username`, `password`, `age`, `email`, `web_page`) VALUES 
        (1, 'Administrator', 'ROLE_ADMIN', 'admin', '$2y$10$Lv4h3U0R/SPvHJ3l/RVTGeXEzdzfQai.ySAnx2DupBXDoWO9wMeKO', '19', 'a@b.com', 'https://web.facebook.com/?_rdc=1&_rdr');
SQL
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE IF EXISTS users');
    }
}

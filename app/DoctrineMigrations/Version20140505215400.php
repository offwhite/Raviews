<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140505215400 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, raview LONGTEXT NOT NULL, rating INT NOT NULL, year INT DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, runtime INT DEFAULT NULL, tagLine VARCHAR(255) DEFAULT NULL, overview LONGTEXT DEFAULT NULL, imagePoster VARCHAR(255) DEFAULT NULL, imageBackground VARCHAR(255) DEFAULT NULL, imdbId VARCHAR(16) DEFAULT NULL, cast LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE movie");
    }
}

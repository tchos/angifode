<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425214816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organismes (id INT AUTO_INCREMENT NOT NULL, libelle_org VARCHAR(255) NOT NULL, region VARCHAR(32) DEFAULT NULL, fax VARCHAR(16) DEFAULT NULL, telephone1 VARCHAR(16) DEFAULT NULL, telephone2 VARCHAR(16) DEFAULT NULL, email VARCHAR(64) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, quartier VARCHAR(255) DEFAULT NULL, sigle VARCHAR(32) NOT NULL, siege VARCHAR(64) DEFAULT NULL, bp VARCHAR(32) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE organismes');
    }
}

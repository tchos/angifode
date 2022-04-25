<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425221613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE points_focaux (id INT AUTO_INCREMENT NOT NULL, id_org_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, telephone VARCHAR(16) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_F8234969D2B4C9F6 (id_org_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE points_focaux ADD CONSTRAINT FK_F8234969D2B4C9F6 FOREIGN KEY (id_org_id) REFERENCES organismes (id)');
        $this->addSql('ALTER TABLE utilisateurs ADD id_org_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315ED2B4C9F6 FOREIGN KEY (id_org_id) REFERENCES organismes (id)');
        $this->addSql('CREATE INDEX IDX_497B315ED2B4C9F6 ON utilisateurs (id_org_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE points_focaux');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY FK_497B315ED2B4C9F6');
        $this->addSql('DROP INDEX IDX_497B315ED2B4C9F6 ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs DROP id_org_id');
    }
}

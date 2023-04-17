<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807152420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_detache ADD organisme_id INT NOT NULL');
        $this->addSql('ALTER TABLE agent_detache ADD CONSTRAINT FK_3D5A9CA35DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organismes (id)');
        $this->addSql('CREATE INDEX IDX_3D5A9CA35DDD38F5 ON agent_detache (organisme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_detache DROP FOREIGN KEY FK_3D5A9CA35DDD38F5');
        $this->addSql('DROP INDEX IDX_3D5A9CA35DDD38F5 ON agent_detache');
        $this->addSql('ALTER TABLE agent_detache DROP organisme_id');
    }
}

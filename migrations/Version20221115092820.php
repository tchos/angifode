<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115092820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fin_detachement (id INT AUTO_INCREMENT NOT NULL, agent_detache_id INT DEFAULT NULL, date_fin_det DATE NOT NULL, motif_fin_det VARCHAR(255) NOT NULL, INDEX IDX_6DC61F15EB355BC8 (agent_detache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fin_detachement ADD CONSTRAINT FK_6DC61F15EB355BC8 FOREIGN KEY (agent_detache_id) REFERENCES agent_detache (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fin_detachement');
    }
}

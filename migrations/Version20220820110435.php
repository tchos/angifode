<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820110435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reversement DROP FOREIGN KEY FK_6D60122314FC0D0B');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D60122314FC0D0B FOREIGN KEY (user_rev_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reversement DROP FOREIGN KEY FK_6D60122314FC0D0B');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D60122314FC0D0B FOREIGN KEY (user_rev_id) REFERENCES utilisateurs (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

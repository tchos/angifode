<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429212452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, code_grade VARCHAR(5) NOT NULL, lib_grade VARCHAR(128) NOT NULL, statut VARCHAR(2) DEFAULT NULL, corps VARCHAR(2) DEFAULT NULL, cadre VARCHAR(2) DEFAULT NULL, categorie VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, type_action VARCHAR(32) NOT NULL, nature VARCHAR(32) NOT NULL, clef VARCHAR(8) NOT NULL, auteur VARCHAR(32) NOT NULL, date_action DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ministere (id INT AUTO_INCREMENT NOT NULL, code_ministere VARCHAR(2) DEFAULT NULL, abrv_ministere VARCHAR(32) DEFAULT NULL, lib_ministere VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_gestion (id INT AUTO_INCREMENT NOT NULL, code_posgest VARCHAR(2) DEFAULT NULL, lib_posgest VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_solde (id INT AUTO_INCREMENT NOT NULL, code_possold VARCHAR(2) DEFAULT NULL, lib_possold VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bareme (id INT AUTO_INCREMENT NOT NULL, num_bar VARCHAR(4) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents ADD date_naissance DATE DEFAULT NULL, ADD sexe VARCHAR(1) DEFAULT NULL, ADD grade VARCHAR(5) DEFAULT NULL, ADD ministere VARCHAR(2) DEFAULT NULL, ADD pos_gest VARCHAR(2) DEFAULT NULL, ADD pos_sold VARCHAR(2) DEFAULT NULL, ADD nap INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE ministere');
        $this->addSql('DROP TABLE position_gestion');
        $this->addSql('DROP TABLE position_solde');
        $this->addSql('DROP TABLE type_bareme');
        $this->addSql('ALTER TABLE agents DROP date_naissance, DROP sexe, DROP grade, DROP ministere, DROP pos_gest, DROP pos_sold, DROP nap');
    }
}

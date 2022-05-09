<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509202928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_detache (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(7) NOT NULL, noms VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, date_integration DATE NOT NULL, ref_acte_int VARCHAR(255) DEFAULT NULL, grade_det VARCHAR(5) NOT NULL, echelon_det VARCHAR(2) NOT NULL, classe_det VARCHAR(2) NOT NULL, ref_acte_det VARCHAR(255) NOT NULL, date_det DATE NOT NULL, date_suspension DATE NOT NULL, date_prise_service DATE NOT NULL, ministere VARCHAR(2) NOT NULL, date_fin_det DATE NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent_detache_organismes (agent_detache_id INT NOT NULL, organismes_id INT NOT NULL, INDEX IDX_8DF4684AEB355BC8 (agent_detache_id), INDEX IDX_8DF4684A2AFB668E (organismes_id), PRIMARY KEY(agent_detache_id, organismes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avancement (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, categorie VARCHAR(5) NOT NULL, grade VARCHAR(5) NOT NULL, echelon VARCHAR(2) NOT NULL, indice INT NOT NULL, ref_acte VARCHAR(255) NOT NULL, date_effet DATE NOT NULL, type_maj VARCHAR(32) NOT NULL, INDEX IDX_6D2A7A2A3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bareme (id INT AUTO_INCREMENT NOT NULL, grade VARCHAR(5) NOT NULL, date_grade DATE NOT NULL, statut VARCHAR(2) NOT NULL, corps VARCHAR(2) NOT NULL, categorie VARCHAR(5) NOT NULL, classe VARCHAR(2) NOT NULL, echelon VARCHAR(2) NOT NULL, indice INT NOT NULL, salaire_base INT NOT NULL, date_salaire DATE NOT NULL, num_bar VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, reversement_id INT NOT NULL, cot_salariale INT DEFAULT NULL, cot_patronale INT DEFAULT NULL, cot_totale INT DEFAULT NULL, indice_cot INT DEFAULT NULL, date_debut_cot DATE NOT NULL, date_fin_cot DATE NOT NULL, date_cotisation DATETIME NOT NULL, INDEX IDX_AE64D2ED3414710B (agent_id), INDEX IDX_AE64D2ED690C2C6F (reversement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reversement (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, user_rev_id INT DEFAULT NULL, type_rev VARCHAR(32) NOT NULL, ref_titre VARCHAR(255) NOT NULL, date_titre DATE NOT NULL, montant_rev INT NOT NULL, date_deb_rev DATE NOT NULL, date_fin_rev DATE NOT NULL, preuve_rev VARCHAR(255) NOT NULL, date_rev DATE NOT NULL, INDEX IDX_6D6012235DDD38F5 (organisme_id), INDEX IDX_6D60122314FC0D0B (user_rev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_detache_organismes ADD CONSTRAINT FK_8DF4684AEB355BC8 FOREIGN KEY (agent_detache_id) REFERENCES agent_detache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_detache_organismes ADD CONSTRAINT FK_8DF4684A2AFB668E FOREIGN KEY (organismes_id) REFERENCES organismes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avancement ADD CONSTRAINT FK_6D2A7A2A3414710B FOREIGN KEY (agent_id) REFERENCES agent_detache (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED3414710B FOREIGN KEY (agent_id) REFERENCES agent_detache (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED690C2C6F FOREIGN KEY (reversement_id) REFERENCES reversement (id)');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D6012235DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organismes (id)');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D60122314FC0D0B FOREIGN KEY (user_rev_id) REFERENCES utilisateurs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_detache_organismes DROP FOREIGN KEY FK_8DF4684AEB355BC8');
        $this->addSql('ALTER TABLE avancement DROP FOREIGN KEY FK_6D2A7A2A3414710B');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED3414710B');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED690C2C6F');
        $this->addSql('DROP TABLE agent_detache');
        $this->addSql('DROP TABLE agent_detache_organismes');
        $this->addSql('DROP TABLE avancement');
        $this->addSql('DROP TABLE bareme');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE reversement');
    }
}

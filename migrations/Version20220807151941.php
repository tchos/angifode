<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807151941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_detache (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(7) NOT NULL, noms VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, date_integration DATE NOT NULL, ref_acte_int VARCHAR(255) DEFAULT NULL, grade_det VARCHAR(5) NOT NULL, echelon_det VARCHAR(2) NOT NULL, classe_det VARCHAR(2) NOT NULL, ref_acte_det VARCHAR(255) NOT NULL, date_det DATE NOT NULL, date_suspension DATE NOT NULL, date_prise_service DATE NOT NULL, ministere VARCHAR(2) NOT NULL, date_fin_det DATE NOT NULL, date_creation DATE NOT NULL, telephone VARCHAR(32) NOT NULL, type_acte_det VARCHAR(32) NOT NULL, date_acte_det DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(7) NOT NULL, noms VARCHAR(255) NOT NULL, date_naissance DATE DEFAULT NULL, sexe VARCHAR(1) DEFAULT NULL, grade VARCHAR(5) DEFAULT NULL, ministere VARCHAR(2) DEFAULT NULL, pos_gest VARCHAR(2) DEFAULT NULL, pos_sold VARCHAR(2) DEFAULT NULL, nap INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avancement (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, categorie VARCHAR(5) NOT NULL, grade VARCHAR(5) NOT NULL, echelon VARCHAR(2) NOT NULL, indice INT NOT NULL, ref_acte VARCHAR(255) NOT NULL, date_effet DATE NOT NULL, type_maj VARCHAR(32) NOT NULL, INDEX IDX_6D2A7A2A3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bareme (id INT AUTO_INCREMENT NOT NULL, grade VARCHAR(5) NOT NULL, date_grade DATE NOT NULL, statut VARCHAR(2) NOT NULL, corps VARCHAR(2) NOT NULL, categorie VARCHAR(5) NOT NULL, classe VARCHAR(2) NOT NULL, echelon VARCHAR(2) NOT NULL, indice INT NOT NULL, salaire_base INT NOT NULL, date_salaire DATE NOT NULL, num_bar VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cotisation (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, reversement_id INT NOT NULL, cot_salariale INT DEFAULT NULL, cot_patronale INT DEFAULT NULL, cot_totale INT DEFAULT NULL, indice_cot INT DEFAULT NULL, date_debut_cot DATE NOT NULL, date_fin_cot DATE NOT NULL, date_cotisation DATETIME NOT NULL, INDEX IDX_AE64D2ED3414710B (agent_id), INDEX IDX_AE64D2ED690C2C6F (reversement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, code_grade VARCHAR(5) NOT NULL, lib_grade VARCHAR(128) NOT NULL, statut VARCHAR(2) DEFAULT NULL, corps VARCHAR(2) DEFAULT NULL, cadre VARCHAR(2) DEFAULT NULL, categorie VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, type_action VARCHAR(32) NOT NULL, nature VARCHAR(32) NOT NULL, clef VARCHAR(8) NOT NULL, auteur VARCHAR(32) NOT NULL, date_action DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ministere (id INT AUTO_INCREMENT NOT NULL, code_ministere VARCHAR(2) DEFAULT NULL, abrv_ministere VARCHAR(32) DEFAULT NULL, lib_ministere VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organismes (id INT AUTO_INCREMENT NOT NULL, libelle_org VARCHAR(255) NOT NULL, region VARCHAR(32) DEFAULT NULL, fax VARCHAR(16) DEFAULT NULL, telephone1 VARCHAR(16) DEFAULT NULL, telephone2 VARCHAR(16) DEFAULT NULL, email VARCHAR(64) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, quartier VARCHAR(255) DEFAULT NULL, sigle VARCHAR(32) NOT NULL, siege VARCHAR(64) DEFAULT NULL, bp VARCHAR(32) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE points_focaux (id INT AUTO_INCREMENT NOT NULL, id_org_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, telephone VARCHAR(16) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_F8234969D2B4C9F6 (id_org_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_gestion (id INT AUTO_INCREMENT NOT NULL, code_posgest VARCHAR(2) DEFAULT NULL, lib_posgest VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position_solde (id INT AUTO_INCREMENT NOT NULL, code_possold VARCHAR(2) DEFAULT NULL, lib_possold VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reversement (id INT AUTO_INCREMENT NOT NULL, organisme_id INT DEFAULT NULL, user_rev_id INT DEFAULT NULL, type_rev VARCHAR(32) NOT NULL, ref_titre VARCHAR(255) NOT NULL, date_titre DATE NOT NULL, montant_rev INT NOT NULL, date_deb_rev DATE NOT NULL, date_fin_rev DATE NOT NULL, preuve_rev VARCHAR(255) NOT NULL, date_rev DATE NOT NULL, INDEX IDX_6D6012235DDD38F5 (organisme_id), INDEX IDX_6D60122314FC0D0B (user_rev_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bareme (id INT AUTO_INCREMENT NOT NULL, num_bar VARCHAR(4) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, id_org_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_497B315EF85E0677 (username), INDEX IDX_497B315ED2B4C9F6 (id_org_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avancement ADD CONSTRAINT FK_6D2A7A2A3414710B FOREIGN KEY (agent_id) REFERENCES agent_detache (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED3414710B FOREIGN KEY (agent_id) REFERENCES agent_detache (id)');
        $this->addSql('ALTER TABLE cotisation ADD CONSTRAINT FK_AE64D2ED690C2C6F FOREIGN KEY (reversement_id) REFERENCES reversement (id)');
        $this->addSql('ALTER TABLE points_focaux ADD CONSTRAINT FK_F8234969D2B4C9F6 FOREIGN KEY (id_org_id) REFERENCES organismes (id)');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D6012235DDD38F5 FOREIGN KEY (organisme_id) REFERENCES organismes (id)');
        $this->addSql('ALTER TABLE reversement ADD CONSTRAINT FK_6D60122314FC0D0B FOREIGN KEY (user_rev_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315ED2B4C9F6 FOREIGN KEY (id_org_id) REFERENCES organismes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avancement DROP FOREIGN KEY FK_6D2A7A2A3414710B');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED3414710B');
        $this->addSql('ALTER TABLE points_focaux DROP FOREIGN KEY FK_F8234969D2B4C9F6');
        $this->addSql('ALTER TABLE reversement DROP FOREIGN KEY FK_6D6012235DDD38F5');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY FK_497B315ED2B4C9F6');
        $this->addSql('ALTER TABLE cotisation DROP FOREIGN KEY FK_AE64D2ED690C2C6F');
        $this->addSql('ALTER TABLE reversement DROP FOREIGN KEY FK_6D60122314FC0D0B');
        $this->addSql('DROP TABLE agent_detache');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE avancement');
        $this->addSql('DROP TABLE bareme');
        $this->addSql('DROP TABLE cotisation');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE ministere');
        $this->addSql('DROP TABLE organismes');
        $this->addSql('DROP TABLE points_focaux');
        $this->addSql('DROP TABLE position_gestion');
        $this->addSql('DROP TABLE position_solde');
        $this->addSql('DROP TABLE reversement');
        $this->addSql('DROP TABLE type_bareme');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

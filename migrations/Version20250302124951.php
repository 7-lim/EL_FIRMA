<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302124951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(55) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, createur_id VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, description VARCHAR(255) NOT NULL, color_code VARCHAR(7) DEFAULT \'#FFFFFF\', INDEX IDX_C0B9F90F73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, emetteur_id VARCHAR(255) DEFAULT NULL, message_id INT DEFAULT NULL, INDEX IDX_AC6340B379E92E8C (emetteur_id), INDEX IDX_AC6340B3537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, terrain_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, prix_location DOUBLE PRECISION NOT NULL, paiement_effectue TINYINT(1) NOT NULL, mode_paiement VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_5E9E89CB8A2D8B41 (terrain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, emetteur_id VARCHAR(255) DEFAULT NULL, discussion_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_B6BD307F79E92E8C (emetteur_id), INDEX IDX_B6BD307F1ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, agriculteur_id INT DEFAULT NULL, administrateur_id INT DEFAULT NULL, objet VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, date_soumission DATE NOT NULL, statut VARCHAR(55) NOT NULL, date_traitement DATE DEFAULT NULL, reponse_admin VARCHAR(255) DEFAULT NULL, INDEX IDX_CE6064047EBB810E (agriculteur_id), INDEX IDX_CE6064047EE5403C (administrateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, agriculteur_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, superficie DOUBLE PRECISION NOT NULL, localisation VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, type_sol VARCHAR(55) NOT NULL, irrigation_disponible TINYINT(1) NOT NULL, statut VARCHAR(55) NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_C87653B17EBB810E (agriculteur_id), INDEX IDX_C87653B1FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id VARCHAR(255) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, number INT NOT NULL, mail VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B379E92E8C FOREIGN KEY (emetteur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB8A2D8B41 FOREIGN KEY (terrain_id) REFERENCES terrain (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79E92E8C FOREIGN KEY (emetteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EE5403C FOREIGN KEY (administrateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B17EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F73A201E5');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B379E92E8C');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3537A1329');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8A2D8B41');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79E92E8C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1ADED311');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EBB810E');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EE5403C');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B17EBB810E');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B1FB88E14F');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE user');
    }
}

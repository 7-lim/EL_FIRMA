<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302012231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE administarteur');
        $this->addSql('DROP TABLE agriculteur');
        $this->addSql('DROP TABLE expert');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', ADD is_blocked TINYINT(1) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD adresse_exploitation VARCHAR(255) DEFAULT NULL, ADD nom_entreprise VARCHAR(255) DEFAULT NULL, ADD id_fiscale VARCHAR(50) DEFAULT NULL, ADD categorie_produit VARCHAR(255) DEFAULT NULL, ADD domaine_expertise VARCHAR(255) DEFAULT NULL, DROP id_utilisateur, DROP role, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE telephone telephone VARCHAR(15) DEFAULT NULL, CHANGE mot_de_passe password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administarteur (id INT AUTO_INCREMENT NOT NULL, privilege VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE agriculteur (id INT AUTO_INCREMENT NOT NULL, localisation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expert (id INT AUTO_INCREMENT NOT NULL, domaine_expertise VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom_entreprise VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, id_fiscale VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD id_utilisateur INT NOT NULL, ADD role VARCHAR(55) NOT NULL, ADD mot_de_passe VARCHAR(255) NOT NULL, DROP roles, DROP password, DROP is_blocked, DROP type, DROP adresse_exploitation, DROP nom_entreprise, DROP id_fiscale, DROP categorie_produit, DROP domaine_expertise, CHANGE email email VARCHAR(55) NOT NULL, CHANGE nom nom VARCHAR(55) NOT NULL, CHANGE prenom prenom VARCHAR(55) NOT NULL, CHANGE telephone telephone INT NOT NULL');
    }
}

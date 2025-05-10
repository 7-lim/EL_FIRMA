<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212133324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(55) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, date_discussion DATE NOT NULL, statut_discussion VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, prix_location DOUBLE PRECISION NOT NULL, paiement_effectue TINYINT(1) NOT NULL, mode_paiement VARCHAR(55) NOT NULL, statut VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) NOT NULL, date_envoie DATE NOT NULL, fichier_joint LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', lu TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, objet VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, date_soumission DATE NOT NULL, statut VARCHAR(55) NOT NULL, date_traitement DATE DEFAULT NULL, reponse_admin VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, superficie DOUBLE PRECISION NOT NULL, localisation VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, type_sol VARCHAR(55) NOT NULL, irrigation_disponible TINYINT(1) NOT NULL, statut VARCHAR(55) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement DROP id_evenement');
        $this->addSql('ALTER TABLE produit DROP id_produit');
        $this->addSql('ALTER TABLE ticket DROP id_ticket');
        $this->addSql('ALTER TABLE utilisateur DROP id_utilisateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('ALTER TABLE evenement ADD id_evenement INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD id_produit INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD id_ticket INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD id_utilisateur INT NOT NULL');
    }
}

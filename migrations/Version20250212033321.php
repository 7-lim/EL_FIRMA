<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212033321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD type VARCHAR(255) NOT NULL, ADD adresse_exploitation VARCHAR(255) DEFAULT NULL, ADD nom_entreprise VARCHAR(255) DEFAULT NULL, ADD id_fiscale VARCHAR(50) DEFAULT NULL, ADD categorie_produit VARCHAR(255) DEFAULT NULL, ADD domaine_expertise VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP type, DROP adresse_exploitation, DROP nom_entreprise, DROP id_fiscale, DROP categorie_produit, DROP domaine_expertise');
    }
}

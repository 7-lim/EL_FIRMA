<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250222184731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD categorie_produit VARCHAR(255) DEFAULT NULL, CHANGE nom_entreprise nom_entreprise VARCHAR(255) DEFAULT NULL, CHANGE id_fiscale id_fiscale VARCHAR(50) DEFAULT NULL, CHANGE domaine_expertise domaine_expertise VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP categorie_produit, CHANGE nom_entreprise nom_entreprise VARCHAR(55) DEFAULT NULL, CHANGE id_fiscale id_fiscale VARCHAR(55) DEFAULT NULL, CHANGE domaine_expertise domaine_expertise VARCHAR(55) DEFAULT NULL');
    }
}

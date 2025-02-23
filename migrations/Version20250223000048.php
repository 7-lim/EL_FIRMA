<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223000048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_expert (evenement_id INT NOT NULL, expert_id INT NOT NULL, INDEX IDX_FCEE43C0FD02F13 (evenement_id), INDEX IDX_FCEE43C0C5568CE4 (expert_id), PRIMARY KEY(evenement_id, expert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement_expert ADD CONSTRAINT FK_FCEE43C0FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_expert ADD CONSTRAINT FK_FCEE43C0C5568CE4 FOREIGN KEY (expert_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP image, CHANGE agriculteur_id agriculteur_id INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE nom_produit nom VARCHAR(255) NOT NULL, CHANGE quantite stock INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD expert_id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404C5568CE4 FOREIGN KEY (expert_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_CE606404C5568CE4 ON reclamation (expert_id)');
        $this->addSql('ALTER TABLE utilisateur ADD domaine_expertise VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement_expert DROP FOREIGN KEY FK_FCEE43C0FD02F13');
        $this->addSql('ALTER TABLE evenement_expert DROP FOREIGN KEY FK_FCEE43C0C5568CE4');
        $this->addSql('DROP TABLE evenement_expert');
        $this->addSql('ALTER TABLE produit ADD image LONGTEXT DEFAULT NULL, CHANGE agriculteur_id agriculteur_id INT NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE nom nom_produit VARCHAR(255) NOT NULL, CHANGE stock quantite INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404C5568CE4');
        $this->addSql('DROP INDEX IDX_CE606404C5568CE4 ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP expert_id');
        $this->addSql('ALTER TABLE utilisateur DROP domaine_expertise');
    }
}

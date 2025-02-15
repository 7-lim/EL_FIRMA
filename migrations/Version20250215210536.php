<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250215210536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247B670C757F');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247BFD02F13');
        $this->addSql('DROP TABLE fournisseur_evenement');
        $this->addSql('ALTER TABLE evenement ADD fournisseurs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E27ACDDFD FOREIGN KEY (fournisseurs_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B26681E27ACDDFD ON evenement (fournisseurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fournisseur_evenement (fournisseur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_F6EC247BFD02F13 (evenement_id), INDEX IDX_F6EC247B670C757F (fournisseur_id), PRIMARY KEY(fournisseur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247B670C757F FOREIGN KEY (fournisseur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E27ACDDFD');
        $this->addSql('DROP INDEX IDX_B26681E27ACDDFD ON evenement');
        $this->addSql('ALTER TABLE evenement DROP fournisseurs_id');
    }
}

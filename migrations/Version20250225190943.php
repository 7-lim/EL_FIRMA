<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225190943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7EE5403C');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E27ACDDFD');
        $this->addSql('DROP INDEX IDX_B26681E7EE5403C ON evenement');
        $this->addSql('DROP INDEX IDX_B26681E27ACDDFD ON evenement');
        $this->addSql('ALTER TABLE evenement ADD utilisateur_id INT DEFAULT NULL, DROP administrateur_id, DROP fournisseurs_id');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B26681EFB88E14F ON evenement (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EFB88E14F');
        $this->addSql('DROP INDEX IDX_B26681EFB88E14F ON evenement');
        $this->addSql('ALTER TABLE evenement ADD fournisseurs_id INT DEFAULT NULL, CHANGE utilisateur_id administrateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7EE5403C FOREIGN KEY (administrateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E27ACDDFD FOREIGN KEY (fournisseurs_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B26681E7EE5403C ON evenement (administrateur_id)');
        $this->addSql('CREATE INDEX IDX_B26681E27ACDDFD ON evenement (fournisseurs_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212154837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administarteur CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE administarteur ADD CONSTRAINT FK_90E9CF8FBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE agriculteur ADD CONSTRAINT FK_2366443BBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expert CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE expert ADD CONSTRAINT FK_4F1B9342BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD disc VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administarteur DROP FOREIGN KEY FK_90E9CF8FBF396750');
        $this->addSql('ALTER TABLE administarteur CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE agriculteur DROP FOREIGN KEY FK_2366443BBF396750');
        $this->addSql('ALTER TABLE agriculteur CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE expert DROP FOREIGN KEY FK_4F1B9342BF396750');
        $this->addSql('ALTER TABLE expert CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32BF396750');
        $this->addSql('ALTER TABLE fournisseur CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP disc');
    }
}

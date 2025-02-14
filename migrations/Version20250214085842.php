<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214085842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF700047D2');
        $this->addSql('DROP TABLE agriculteur_ticket');
        $this->addSql('ALTER TABLE agriculteur ADD tickets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agriculteur ADD CONSTRAINT FK_2366443B8FDC0E9A FOREIGN KEY (tickets_id) REFERENCES ticket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2366443B8FDC0E9A ON agriculteur (tickets_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agriculteur_ticket (agriculteur_id INT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_F4CB71CF7EBB810E (agriculteur_id), INDEX IDX_F4CB71CF700047D2 (ticket_id), PRIMARY KEY(agriculteur_id, ticket_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur DROP FOREIGN KEY FK_2366443B8FDC0E9A');
        $this->addSql('DROP INDEX UNIQ_2366443B8FDC0E9A ON agriculteur');
        $this->addSql('ALTER TABLE agriculteur DROP tickets_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214095939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FAFD02F13');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FA7EBB810E');
        $this->addSql('DROP TABLE agriculteur_evenement');
        $this->addSql('ALTER TABLE agriculteur DROP FOREIGN KEY FK_2366443B8FDC0E9A');
        $this->addSql('DROP INDEX UNIQ_2366443B8FDC0E9A ON agriculteur');
        $this->addSql('ALTER TABLE agriculteur DROP tickets_id');
        $this->addSql('ALTER TABLE ticket ADD agriculteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA37EBB810E ON ticket (agriculteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agriculteur_evenement (agriculteur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_BD0668FA7EBB810E (agriculteur_id), INDEX IDX_BD0668FAFD02F13 (evenement_id), PRIMARY KEY(agriculteur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FA7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur ADD tickets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agriculteur ADD CONSTRAINT FK_2366443B8FDC0E9A FOREIGN KEY (tickets_id) REFERENCES ticket (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2366443B8FDC0E9A ON agriculteur (tickets_id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37EBB810E');
        $this->addSql('DROP INDEX IDX_97A0ADA37EBB810E ON ticket');
        $this->addSql('ALTER TABLE ticket DROP agriculteur_id');
    }
}

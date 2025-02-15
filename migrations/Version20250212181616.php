<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212181616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agriculteur_evenement (agriculteur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_BD0668FA7EBB810E (agriculteur_id), INDEX IDX_BD0668FAFD02F13 (evenement_id), PRIMARY KEY(agriculteur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agriculteur_ticket (agriculteur_id INT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_F4CB71CF7EBB810E (agriculteur_id), INDEX IDX_F4CB71CF700047D2 (ticket_id), PRIMARY KEY(agriculteur_id, ticket_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur_evenement (fournisseur_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_F6EC247B670C757F (fournisseur_id), INDEX IDX_F6EC247BFD02F13 (evenement_id), PRIMARY KEY(fournisseur_id, evenement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FA7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247B670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247BFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administarteur DROP FOREIGN KEY FK_90E9CF8FBF396750');
        $this->addSql('DROP TABLE administarteur');
        $this->addSql('ALTER TABLE discussion ADD agriculteur_id INT DEFAULT NULL, ADD expert_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FC5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90F7EBB810E ON discussion (agriculteur_id)');
        $this->addSql('CREATE INDEX IDX_C0B9F90FC5568CE4 ON discussion (expert_id)');
        $this->addSql('ALTER TABLE evenement ADD administrateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id)');
        $this->addSql('CREATE INDEX IDX_B26681E7EE5403C ON evenement (administrateur_id)');
        $this->addSql('ALTER TABLE produit ADD fournisseur_id INT NOT NULL, ADD agriculteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27670C757F ON produit (fournisseur_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC277EBB810E ON produit (agriculteur_id)');
        $this->addSql('ALTER TABLE reclamation ADD agriculteur_id INT DEFAULT NULL, ADD administrateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id)');
        $this->addSql('CREATE INDEX IDX_CE6064047EBB810E ON reclamation (agriculteur_id)');
        $this->addSql('CREATE INDEX IDX_CE6064047EE5403C ON reclamation (administrateur_id)');
        $this->addSql('ALTER TABLE terrain ADD agriculteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B17EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('CREATE INDEX IDX_C87653B17EBB810E ON terrain (agriculteur_id)');
        $this->addSql('ALTER TABLE ticket ADD expert_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C5568CE4 ON ticket (expert_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7EE5403C');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EE5403C');
        $this->addSql('CREATE TABLE administarteur (id INT NOT NULL, privilege VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE administarteur ADD CONSTRAINT FK_90E9CF8FBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8BF396750');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FA7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FAFD02F13');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF700047D2');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247B670C757F');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247BFD02F13');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE agriculteur_evenement');
        $this->addSql('DROP TABLE agriculteur_ticket');
        $this->addSql('DROP TABLE fournisseur_evenement');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7EBB810E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FC5568CE4');
        $this->addSql('DROP INDEX IDX_C0B9F90F7EBB810E ON discussion');
        $this->addSql('DROP INDEX IDX_C0B9F90FC5568CE4 ON discussion');
        $this->addSql('ALTER TABLE discussion DROP agriculteur_id, DROP expert_id');
        $this->addSql('DROP INDEX IDX_B26681E7EE5403C ON evenement');
        $this->addSql('ALTER TABLE evenement DROP administrateur_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277EBB810E');
        $this->addSql('DROP INDEX IDX_29A5EC27670C757F ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC277EBB810E ON produit');
        $this->addSql('ALTER TABLE produit DROP fournisseur_id, DROP agriculteur_id');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EBB810E');
        $this->addSql('DROP INDEX IDX_CE6064047EBB810E ON reclamation');
        $this->addSql('DROP INDEX IDX_CE6064047EE5403C ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP agriculteur_id, DROP administrateur_id');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B17EBB810E');
        $this->addSql('DROP INDEX IDX_C87653B17EBB810E ON terrain');
        $this->addSql('ALTER TABLE terrain DROP agriculteur_id');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C5568CE4');
        $this->addSql('DROP INDEX IDX_97A0ADA3C5568CE4 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP expert_id');
    }
}

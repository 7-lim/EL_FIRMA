<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224153029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7EE5403C');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EE5403C');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FA7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF7EBB810E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7EBB810E');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277EBB810E');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EBB810E');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B17EBB810E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FC5568CE4');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C5568CE4');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247B670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8BF396750');
        $this->addSql('ALTER TABLE agriculteur DROP FOREIGN KEY FK_2366443BBF396750');
        $this->addSql('ALTER TABLE expert DROP FOREIGN KEY FK_4F1B9342BF396750');
        $this->addSql('ALTER TABLE fournisseur DROP FOREIGN KEY FK_369ECA32BF396750');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE agriculteur');
        $this->addSql('DROP TABLE expert');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7EBB810E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FC5568CE4');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FC5568CE4 FOREIGN KEY (expert_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7EE5403C');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7EE5403C FOREIGN KEY (administrateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277EBB810E');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EBB810E');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EE5403C');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EE5403C FOREIGN KEY (administrateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B17EBB810E');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B17EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C5568CE4');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C5568CE4 FOREIGN KEY (expert_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD localisation VARCHAR(255) DEFAULT NULL, ADD actif TINYINT(1) DEFAULT NULL, ADD nom_entreprise VARCHAR(55) DEFAULT NULL, ADD id_fiscale VARCHAR(55) DEFAULT NULL, ADD domaine_expertise VARCHAR(55) DEFAULT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE telephone telephone VARCHAR(50) DEFAULT NULL, CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE mot_de_passe password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FA7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FA7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247B670C757F');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247B670C757F FOREIGN KEY (fournisseur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE agriculteur (id INT NOT NULL, localisation VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expert (id INT NOT NULL, domaine_expertise VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, nom_entreprise VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, id_fiscale VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur ADD CONSTRAINT FK_2366443BBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expert ADD CONSTRAINT FK_4F1B9342BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fournisseur ADD CONSTRAINT FK_369ECA32BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_evenement DROP FOREIGN KEY FK_BD0668FA7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_evenement ADD CONSTRAINT FK_BD0668FA7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agriculteur_ticket DROP FOREIGN KEY FK_F4CB71CF7EBB810E');
        $this->addSql('ALTER TABLE agriculteur_ticket ADD CONSTRAINT FK_F4CB71CF7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F7EBB810E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90FC5568CE4');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F7EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FC5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7EE5403C');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E7EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id)');
        $this->addSql('ALTER TABLE fournisseur_evenement DROP FOREIGN KEY FK_F6EC247B670C757F');
        $this->addSql('ALTER TABLE fournisseur_evenement ADD CONSTRAINT FK_F6EC247B670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27670C757F');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277EBB810E');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EBB810E');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064047EE5403C');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064047EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id)');
        $this->addSql('ALTER TABLE terrain DROP FOREIGN KEY FK_C87653B17EBB810E');
        $this->addSql('ALTER TABLE terrain ADD CONSTRAINT FK_C87653B17EBB810E FOREIGN KEY (agriculteur_id) REFERENCES agriculteur (id)');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C5568CE4');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C5568CE4 FOREIGN KEY (expert_id) REFERENCES expert (id)');
        $this->addSql('ALTER TABLE utilisateur DROP localisation, DROP actif, DROP nom_entreprise, DROP id_fiscale, DROP domaine_expertise, CHANGE nom nom VARCHAR(55) NOT NULL, CHANGE prenom prenom VARCHAR(55) NOT NULL, CHANGE email email VARCHAR(55) NOT NULL, CHANGE telephone telephone INT NOT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE password mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }
}

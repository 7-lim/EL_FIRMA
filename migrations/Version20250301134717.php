<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250301134717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, createur_id VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, description VARCHAR(255) NOT NULL, color_code VARCHAR(7) DEFAULT \'#FFFFFF\', INDEX IDX_C0B9F90F73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, emetteur_id VARCHAR(255) DEFAULT NULL, message_id INT DEFAULT NULL, INDEX IDX_AC6340B379E92E8C (emetteur_id), INDEX IDX_AC6340B3537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, emetteur_id VARCHAR(255) DEFAULT NULL, discussion_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_B6BD307F79E92E8C (emetteur_id), INDEX IDX_B6BD307F1ADED311 (discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id VARCHAR(255) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, number INT NOT NULL, mail VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(180) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B379E92E8C FOREIGN KEY (emetteur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79E92E8C FOREIGN KEY (emetteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1ADED311 FOREIGN KEY (discussion_id) REFERENCES discussion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F73A201E5');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B379E92E8C');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3537A1329');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79E92E8C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1ADED311');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

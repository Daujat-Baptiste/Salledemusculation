<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114074733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, actif VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2994CBE7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, id_rubrique_id INT DEFAULT NULL, redacteur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_23A0E6623C145C4 (id_rubrique_id), INDEX IDX_23A0E66764D0490 (redacteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, lu TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, semaine INT NOT NULL, annee INT NOT NULL, jour VARCHAR(255) NOT NULL, heuredebut TIME NOT NULL, heurefin TIME NOT NULL, coach VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redacteur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_84964B15A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscrire (user_id INT NOT NULL, abonnement_id INT NOT NULL, INDEX IDX_6D79C2CCA76ED395 (user_id), INDEX IDX_6D79C2CCF1D74413 (abonnement_id), PRIMARY KEY(user_id, abonnement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, newsletter TINYINT(1) NOT NULL, numtel VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6623C145C4 FOREIGN KEY (id_rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66764D0490 FOREIGN KEY (redacteur_id) REFERENCES redacteur (id)');
        $this->addSql('ALTER TABLE redacteur ADD CONSTRAINT FK_84964B15A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE souscrire ADD CONSTRAINT FK_6D79C2CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE souscrire ADD CONSTRAINT FK_6D79C2CCF1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE souscrire DROP FOREIGN KEY FK_6D79C2CCF1D74413');
        $this->addSql('ALTER TABLE accueil DROP FOREIGN KEY FK_2994CBE7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66764D0490');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6623C145C4');
        $this->addSql('ALTER TABLE redacteur DROP FOREIGN KEY FK_84964B15A76ED395');
        $this->addSql('ALTER TABLE souscrire DROP FOREIGN KEY FK_6D79C2CCA76ED395');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE accueil');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE redacteur');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE souscrire');
        $this->addSql('DROP TABLE user');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201014195140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accueil (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2994CBE7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accueil ADD CONSTRAINT FK_2994CBE7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article ADD redacteur_id INT DEFAULT NULL, DROP auteur');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66764D0490 FOREIGN KEY (redacteur_id) REFERENCES redacteur (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66764D0490 ON article (redacteur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE accueil');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66764D0490');
        $this->addSql('DROP INDEX IDX_23A0E66764D0490 ON article');
        $this->addSql('ALTER TABLE article ADD auteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP redacteur_id');
    }
}

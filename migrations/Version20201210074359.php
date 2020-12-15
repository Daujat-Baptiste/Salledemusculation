<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210074359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE souscrire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, abonnement_id INT DEFAULT NULL, INDEX IDX_6D79C2CCA76ED395 (user_id), INDEX IDX_6D79C2CCF1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE souscrire ADD CONSTRAINT FK_6D79C2CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE souscrire ADD CONSTRAINT FK_6D79C2CCF1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE redacteur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE redacteur ADD CONSTRAINT FK_84964B15A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_84964B15A76ED395 ON redacteur (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE souscrire');
        $this->addSql('ALTER TABLE redacteur DROP FOREIGN KEY FK_84964B15A76ED395');
        $this->addSql('DROP INDEX UNIQ_84964B15A76ED395 ON redacteur');
        $this->addSql('ALTER TABLE redacteur DROP user_id');
    }
}

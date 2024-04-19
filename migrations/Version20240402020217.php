<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402020217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponsee ADD id_reclamation INT DEFAULT NULL, CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE reponsee ADD CONSTRAINT FK_EA859B97D672A9F3 FOREIGN KEY (id_reclamation) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX id_reclamation ON reponsee (id_reclamation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponsee DROP FOREIGN KEY FK_EA859B97D672A9F3');
        $this->addSql('DROP INDEX id_reclamation ON reponsee');
        $this->addSql('ALTER TABLE reponsee DROP id_reclamation, CHANGE description description VARCHAR(255) NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528173453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couleurs ADD sous_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE couleurs ADD CONSTRAINT FK_CB52D47B365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('CREATE INDEX IDX_CB52D47B365BF48 ON couleurs (sous_categorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couleurs DROP FOREIGN KEY FK_CB52D47B365BF48');
        $this->addSql('DROP INDEX IDX_CB52D47B365BF48 ON couleurs');
        $this->addSql('ALTER TABLE couleurs DROP sous_categorie_id');
    }
}

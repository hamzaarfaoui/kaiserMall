<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605162534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners ADD sous_categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F25689F751138 FOREIGN KEY (sous_categories_id) REFERENCES sous_categories (id)');
        $this->addSql('CREATE INDEX IDX_250F25689F751138 ON banners (sous_categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F25689F751138');
        $this->addSql('DROP INDEX IDX_250F25689F751138 ON banners');
        $this->addSql('ALTER TABLE banners DROP sous_categories_id');
    }
}

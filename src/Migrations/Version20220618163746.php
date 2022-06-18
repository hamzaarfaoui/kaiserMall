<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220618163746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F2568B092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('CREATE INDEX IDX_250F2568B092A811 ON banners (store_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F2568B092A811');
        $this->addSql('DROP INDEX IDX_250F2568B092A811 ON banners');
        $this->addSql('ALTER TABLE banners DROP store_id');
    }
}

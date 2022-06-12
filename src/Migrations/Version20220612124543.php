<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612124543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris ADD product_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4324584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8933C4324584665A ON favoris (product_id)');
        $this->addSql('CREATE INDEX IDX_8933C432A76ED395 ON favoris (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4324584665A');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('DROP INDEX IDX_8933C4324584665A ON favoris');
        $this->addSql('DROP INDEX IDX_8933C432A76ED395 ON favoris');
        $this->addSql('ALTER TABLE favoris DROP product_id, DROP user_id');
    }
}

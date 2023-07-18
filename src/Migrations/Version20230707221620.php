<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230707221620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A1D24927');
        $this->addSql('DROP INDEX IDX_B3BA5A5A1D24927 ON products');
        $this->addSql('ALTER TABLE products DROP products_sponsors_id');
        $this->addSql('ALTER TABLE products_sponsors ADD id_product INT NOT NULL, ADD id_store INT NOT NULL');
        $this->addSql('ALTER TABLE stores DROP FOREIGN KEY FK_D5907CCC1D24927');
        $this->addSql('DROP INDEX IDX_D5907CCC1D24927 ON stores');
        $this->addSql('ALTER TABLE stores DROP products_sponsors_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD products_sponsors_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A1D24927 FOREIGN KEY (products_sponsors_id) REFERENCES products_sponsors (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A1D24927 ON products (products_sponsors_id)');
        $this->addSql('ALTER TABLE products_sponsors DROP id_product, DROP id_store');
        $this->addSql('ALTER TABLE stores ADD products_sponsors_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stores ADD CONSTRAINT FK_D5907CCC1D24927 FOREIGN KEY (products_sponsors_id) REFERENCES products_sponsors (id)');
        $this->addSql('CREATE INDEX IDX_D5907CCC1D24927 ON stores (products_sponsors_id)');
    }
}

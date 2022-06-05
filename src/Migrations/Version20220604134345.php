<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604134345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_has_products (id INT AUTO_INCREMENT NOT NULL, list_product_id INT DEFAULT NULL, product_id INT DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_D83945759FA91286 (list_product_id), INDEX IDX_D83945754584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_has_products ADD CONSTRAINT FK_D83945759FA91286 FOREIGN KEY (list_product_id) REFERENCES products_list (id)');
        $this->addSql('ALTER TABLE list_has_products ADD CONSTRAINT FK_D83945754584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('DROP TABLE products_list_products');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_list_products (products_list_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_FCDEC0426C8A81A9 (products_id), INDEX IDX_FCDEC042E693ECD6 (products_list_id), PRIMARY KEY(products_list_id, products_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE products_list_products ADD CONSTRAINT FK_FCDEC0426C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_list_products ADD CONSTRAINT FK_FCDEC042E693ECD6 FOREIGN KEY (products_list_id) REFERENCES products_list (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE list_has_products');
    }
}

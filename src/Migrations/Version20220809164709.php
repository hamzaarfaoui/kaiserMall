<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220809164709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_liees (id INT AUTO_INCREMENT NOT NULL, product_main_id INT DEFAULT NULL, relation VARCHAR(255) DEFAULT NULL, INDEX IDX_A30D9DA7B3A7BC3A (product_main_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_liees_products (products_liees_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_576553BF28069C (products_liees_id), INDEX IDX_576553BF6C8A81A9 (products_id), PRIMARY KEY(products_liees_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_liees ADD CONSTRAINT FK_A30D9DA7B3A7BC3A FOREIGN KEY (product_main_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products_liees_products ADD CONSTRAINT FK_576553BF28069C FOREIGN KEY (products_liees_id) REFERENCES products_liees (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_liees_products ADD CONSTRAINT FK_576553BF6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_liees_products DROP FOREIGN KEY FK_576553BF28069C');
        $this->addSql('DROP TABLE products_liees');
        $this->addSql('DROP TABLE products_liees_products');
    }
}

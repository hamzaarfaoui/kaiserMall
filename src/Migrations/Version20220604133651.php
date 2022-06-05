<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604133651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_list_products (products_list_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_FCDEC042E693ECD6 (products_list_id), INDEX IDX_FCDEC0426C8A81A9 (products_id), PRIMARY KEY(products_list_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_list_products ADD CONSTRAINT FK_FCDEC042E693ECD6 FOREIGN KEY (products_list_id) REFERENCES products_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_list_products ADD CONSTRAINT FK_FCDEC0426C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE products_products_list');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_products_list (products_id INT NOT NULL, products_list_id INT NOT NULL, INDEX IDX_F9D69F6AE693ECD6 (products_list_id), INDEX IDX_F9D69F6A6C8A81A9 (products_id), PRIMARY KEY(products_id, products_list_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE products_products_list ADD CONSTRAINT FK_F9D69F6A6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_products_list ADD CONSTRAINT FK_F9D69F6AE693ECD6 FOREIGN KEY (products_list_id) REFERENCES products_list (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE products_list_products');
    }
}

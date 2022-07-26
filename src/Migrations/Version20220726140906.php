<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726140906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures ADD commande_id INT DEFAULT NULL, ADD marchand_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B3E6422B1 FOREIGN KEY (marchand_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_647590B82EA2E54 ON factures (commande_id)');
        $this->addSql('CREATE INDEX IDX_647590B3E6422B1 ON factures (marchand_id)');
        $this->addSql('CREATE INDEX IDX_647590B4584665A ON factures (product_id)');
        $this->addSql('CREATE INDEX IDX_647590B19EB6921 ON factures (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B82EA2E54');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B3E6422B1');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B4584665A');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B19EB6921');
        $this->addSql('DROP INDEX IDX_647590B82EA2E54 ON factures');
        $this->addSql('DROP INDEX IDX_647590B3E6422B1 ON factures');
        $this->addSql('DROP INDEX IDX_647590B4584665A ON factures');
        $this->addSql('DROP INDEX IDX_647590B19EB6921 ON factures');
        $this->addSql('ALTER TABLE factures DROP commande_id, DROP marchand_id, DROP product_id, DROP client_id');
    }
}

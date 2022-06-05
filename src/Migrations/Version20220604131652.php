<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604131652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F2568E693ECD6');
        $this->addSql('DROP INDEX IDX_250F2568E693ECD6 ON banners');
        $this->addSql('ALTER TABLE banners DROP products_list_id');
        $this->addSql('ALTER TABLE products_list ADD slider_id INT DEFAULT NULL, ADD banner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products_list ADD CONSTRAINT FK_C8DF36122CCC9638 FOREIGN KEY (slider_id) REFERENCES sliders (id)');
        $this->addSql('ALTER TABLE products_list ADD CONSTRAINT FK_C8DF3612684EC833 FOREIGN KEY (banner_id) REFERENCES banners (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8DF36122CCC9638 ON products_list (slider_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C8DF3612684EC833 ON products_list (banner_id)');
        $this->addSql('ALTER TABLE sliders DROP FOREIGN KEY FK_85A59DB8E693ECD6');
        $this->addSql('DROP INDEX IDX_85A59DB8E693ECD6 ON sliders');
        $this->addSql('ALTER TABLE sliders DROP products_list_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banners ADD products_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F2568E693ECD6 FOREIGN KEY (products_list_id) REFERENCES products_list (id)');
        $this->addSql('CREATE INDEX IDX_250F2568E693ECD6 ON banners (products_list_id)');
        $this->addSql('ALTER TABLE products_list DROP FOREIGN KEY FK_C8DF36122CCC9638');
        $this->addSql('ALTER TABLE products_list DROP FOREIGN KEY FK_C8DF3612684EC833');
        $this->addSql('DROP INDEX UNIQ_C8DF36122CCC9638 ON products_list');
        $this->addSql('DROP INDEX UNIQ_C8DF3612684EC833 ON products_list');
        $this->addSql('ALTER TABLE products_list DROP slider_id, DROP banner_id');
        $this->addSql('ALTER TABLE sliders ADD products_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sliders ADD CONSTRAINT FK_85A59DB8E693ECD6 FOREIGN KEY (products_list_id) REFERENCES products_list (id)');
        $this->addSql('CREATE INDEX IDX_85A59DB8E693ECD6 ON sliders (products_list_id)');
    }
}

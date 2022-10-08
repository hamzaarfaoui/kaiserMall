<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008135237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses_store (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, residence VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, gouvernaurat VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, INDEX IDX_B2A732EBB092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresses_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, residence VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, gouvernaurat VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, INDEX IDX_CF981229A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banners (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, sous_categories_id INT DEFAULT NULL, store_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, is_two TINYINT(1) DEFAULT NULL, is_three TINYINT(1) DEFAULT NULL, position INT DEFAULT NULL, debut DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, INDEX IDX_250F25684584665A (product_id), INDEX IDX_250F25689F751138 (sous_categories_id), INDEX IDX_250F2568B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristiques (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, INDEX IDX_61B5DA1D365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, categorie_mere_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, icone VARCHAR(255) DEFAULT NULL, INDEX IDX_3AF34668665D6AAC (categorie_mere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_mere (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, icone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status INT DEFAULT NULL, facture LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_35D4282CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couleurs (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_CB52D47B365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factures (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, marchand_id INT DEFAULT NULL, product_id INT DEFAULT NULL, client_id INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, qte INT DEFAULT NULL, INDEX IDX_647590B82EA2E54 (commande_id), INDEX IDX_647590B3E6422B1 (marchand_id), INDEX IDX_647590B4584665A (product_id), INDEX IDX_647590B19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_8933C4324584665A (product_id), INDEX IDX_8933C432A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keywords (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_AA5FB55E4584665A (product_id), INDEX IDX_AA5FB55EBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liees (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_has_products (id INT AUTO_INCREMENT NOT NULL, list_product_id INT DEFAULT NULL, product_id INT DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_D83945759FA91286 (list_product_id), INDEX IDX_D83945754584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marchands (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nrc VARCHAR(255) DEFAULT NULL, matricule_fiscale VARCHAR(255) DEFAULT NULL, INDEX IDX_2FFAA6BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, sous_categorie_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, status INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, INDEX IDX_67884F2D365BF48 (sous_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_images (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_D622A8B94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medias_videos (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1F9772E14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_letter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE others (id INT AUTO_INCREMENT NOT NULL, main INT NOT NULL, liee INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, marque_id INT DEFAULT NULL, store_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, couleur_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, price_promotion DOUBLE PRECISION DEFAULT NULL, content LONGTEXT DEFAULT NULL, is_deleted INT DEFAULT NULL, nbr_view INT DEFAULT NULL, nbr_add_to_cart INT DEFAULT NULL, nbr_add_to_favorite INT DEFAULT NULL, status INT DEFAULT NULL, qte INT DEFAULT NULL, position INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, in_list_products INT DEFAULT NULL, liees LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_B3BA5A5A4827B9B2 (marque_id), INDEX IDX_B3BA5A5AB092A811 (store_id), INDEX IDX_B3BA5A5A365BF48 (sous_categorie_id), INDEX IDX_B3BA5A5AC31BA576 (couleur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_valeurs (products_id INT NOT NULL, valeurs_id INT NOT NULL, INDEX IDX_DC4410F96C8A81A9 (products_id), INDEX IDX_DC4410F93578E275 (valeurs_id), PRIMARY KEY(products_id, valeurs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_liees (id INT AUTO_INCREMENT NOT NULL, product_main_id INT DEFAULT NULL, relation VARCHAR(255) DEFAULT NULL, INDEX IDX_A30D9DA7B3A7BC3A (product_main_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_liees_products (products_liees_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_576553BF28069C (products_liees_id), INDEX IDX_576553BF6C8A81A9 (products_id), PRIMARY KEY(products_liees_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_list (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, slider_id INT DEFAULT NULL, banner_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, couleur VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_C8DF3612B092A811 (store_id), UNIQUE INDEX UNIQ_C8DF36122CCC9638 (slider_id), UNIQUE INDEX UNIQ_C8DF3612684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotions (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, variable DOUBLE PRECISION DEFAULT NULL, fixe DOUBLE PRECISION DEFAULT NULL, status INT DEFAULT NULL, debut DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_EA1B30344584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sliders (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, ordre INT DEFAULT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_85A59DB84584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_categories (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, show_in_index INT DEFAULT NULL, order_in_index INT DEFAULT NULL, has_banner INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, icone VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, show_products INT DEFAULT NULL, show_banners INT DEFAULT NULL, listes_title VARCHAR(255) DEFAULT NULL, show_list_products INT DEFAULT NULL, INDEX IDX_DC8B1382BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stores (id INT AUTO_INCREMENT NOT NULL, marchand_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, image_couverture VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, nbr_view INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, prix INT DEFAULT NULL, debut_offre DATETIME DEFAULT NULL, fin_offre DATETIME DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_D5907CCC3E6422B1 (marchand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephones_store (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, INDEX IDX_D897BA89B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephones_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, numero VARCHAR(255) DEFAULT NULL, INDEX IDX_4F308238A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, adress_livraison VARCHAR(255) DEFAULT NULL, city_livraison VARCHAR(255) DEFAULT NULL, country_livraison VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), INDEX IDX_8D93D6497E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE valeurs (id INT AUTO_INCREMENT NOT NULL, caracteristique_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_779EAA41704EEB7 (caracteristique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses_store ADD CONSTRAINT FK_B2A732EBB092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE adresses_user ADD CONSTRAINT FK_CF981229A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F25684584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F25689F751138 FOREIGN KEY (sous_categories_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE banners ADD CONSTRAINT FK_250F2568B092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE caracteristiques ADD CONSTRAINT FK_61B5DA1D365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668665D6AAC FOREIGN KEY (categorie_mere_id) REFERENCES categories_mere (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE couleurs ADD CONSTRAINT FK_CB52D47B365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B3E6422B1 FOREIGN KEY (marchand_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE factures ADD CONSTRAINT FK_647590B19EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4324584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE keywords ADD CONSTRAINT FK_AA5FB55E4584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE keywords ADD CONSTRAINT FK_AA5FB55EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE list_has_products ADD CONSTRAINT FK_D83945759FA91286 FOREIGN KEY (list_product_id) REFERENCES products_list (id)');
        $this->addSql('ALTER TABLE list_has_products ADD CONSTRAINT FK_D83945754584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE marchands ADD CONSTRAINT FK_2FFAA6BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE marques ADD CONSTRAINT FK_67884F2D365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE medias_images ADD CONSTRAINT FK_D622A8B94584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE medias_videos ADD CONSTRAINT FK_1F9772E14584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A4827B9B2 FOREIGN KEY (marque_id) REFERENCES marques (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AB092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES sous_categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AC31BA576 FOREIGN KEY (couleur_id) REFERENCES couleurs (id)');
        $this->addSql('ALTER TABLE products_valeurs ADD CONSTRAINT FK_DC4410F96C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_valeurs ADD CONSTRAINT FK_DC4410F93578E275 FOREIGN KEY (valeurs_id) REFERENCES valeurs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_liees ADD CONSTRAINT FK_A30D9DA7B3A7BC3A FOREIGN KEY (product_main_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE products_liees_products ADD CONSTRAINT FK_576553BF28069C FOREIGN KEY (products_liees_id) REFERENCES products_liees (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_liees_products ADD CONSTRAINT FK_576553BF6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_list ADD CONSTRAINT FK_C8DF3612B092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE products_list ADD CONSTRAINT FK_C8DF36122CCC9638 FOREIGN KEY (slider_id) REFERENCES sliders (id)');
        $this->addSql('ALTER TABLE products_list ADD CONSTRAINT FK_C8DF3612684EC833 FOREIGN KEY (banner_id) REFERENCES banners (id)');
        $this->addSql('ALTER TABLE promotions ADD CONSTRAINT FK_EA1B30344584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE sliders ADD CONSTRAINT FK_85A59DB84584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE sous_categories ADD CONSTRAINT FK_DC8B1382BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE stores ADD CONSTRAINT FK_D5907CCC3E6422B1 FOREIGN KEY (marchand_id) REFERENCES marchands (id)');
        $this->addSql('ALTER TABLE telephones_store ADD CONSTRAINT FK_D897BA89B092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('ALTER TABLE telephones_user ADD CONSTRAINT FK_4F308238A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE valeurs ADD CONSTRAINT FK_779EAA41704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristiques (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_list DROP FOREIGN KEY FK_C8DF3612684EC833');
        $this->addSql('ALTER TABLE valeurs DROP FOREIGN KEY FK_779EAA41704EEB7');
        $this->addSql('ALTER TABLE sous_categories DROP FOREIGN KEY FK_DC8B1382BCF5E72D');
        $this->addSql('ALTER TABLE categories DROP FOREIGN KEY FK_3AF34668665D6AAC');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B82EA2E54');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AC31BA576');
        $this->addSql('ALTER TABLE stores DROP FOREIGN KEY FK_D5907CCC3E6422B1');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A4827B9B2');
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F25684584665A');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B4584665A');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4324584665A');
        $this->addSql('ALTER TABLE keywords DROP FOREIGN KEY FK_AA5FB55E4584665A');
        $this->addSql('ALTER TABLE list_has_products DROP FOREIGN KEY FK_D83945754584665A');
        $this->addSql('ALTER TABLE medias_images DROP FOREIGN KEY FK_D622A8B94584665A');
        $this->addSql('ALTER TABLE medias_videos DROP FOREIGN KEY FK_1F9772E14584665A');
        $this->addSql('ALTER TABLE products_valeurs DROP FOREIGN KEY FK_DC4410F96C8A81A9');
        $this->addSql('ALTER TABLE products_liees DROP FOREIGN KEY FK_A30D9DA7B3A7BC3A');
        $this->addSql('ALTER TABLE products_liees_products DROP FOREIGN KEY FK_576553BF6C8A81A9');
        $this->addSql('ALTER TABLE promotions DROP FOREIGN KEY FK_EA1B30344584665A');
        $this->addSql('ALTER TABLE sliders DROP FOREIGN KEY FK_85A59DB84584665A');
        $this->addSql('ALTER TABLE products_liees_products DROP FOREIGN KEY FK_576553BF28069C');
        $this->addSql('ALTER TABLE list_has_products DROP FOREIGN KEY FK_D83945759FA91286');
        $this->addSql('ALTER TABLE products_list DROP FOREIGN KEY FK_C8DF36122CCC9638');
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F25689F751138');
        $this->addSql('ALTER TABLE caracteristiques DROP FOREIGN KEY FK_61B5DA1D365BF48');
        $this->addSql('ALTER TABLE couleurs DROP FOREIGN KEY FK_CB52D47B365BF48');
        $this->addSql('ALTER TABLE keywords DROP FOREIGN KEY FK_AA5FB55EBCF5E72D');
        $this->addSql('ALTER TABLE marques DROP FOREIGN KEY FK_67884F2D365BF48');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A365BF48');
        $this->addSql('ALTER TABLE adresses_store DROP FOREIGN KEY FK_B2A732EBB092A811');
        $this->addSql('ALTER TABLE banners DROP FOREIGN KEY FK_250F2568B092A811');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B3E6422B1');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AB092A811');
        $this->addSql('ALTER TABLE products_list DROP FOREIGN KEY FK_C8DF3612B092A811');
        $this->addSql('ALTER TABLE telephones_store DROP FOREIGN KEY FK_D897BA89B092A811');
        $this->addSql('ALTER TABLE adresses_user DROP FOREIGN KEY FK_CF981229A76ED395');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CA76ED395');
        $this->addSql('ALTER TABLE factures DROP FOREIGN KEY FK_647590B19EB6921');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE marchands DROP FOREIGN KEY FK_2FFAA6BA76ED395');
        $this->addSql('ALTER TABLE telephones_user DROP FOREIGN KEY FK_4F308238A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497E3C61F9');
        $this->addSql('ALTER TABLE products_valeurs DROP FOREIGN KEY FK_DC4410F93578E275');
        $this->addSql('DROP TABLE adresses_store');
        $this->addSql('DROP TABLE adresses_user');
        $this->addSql('DROP TABLE banners');
        $this->addSql('DROP TABLE caracteristiques');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_mere');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE couleurs');
        $this->addSql('DROP TABLE factures');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE keywords');
        $this->addSql('DROP TABLE liees');
        $this->addSql('DROP TABLE list_has_products');
        $this->addSql('DROP TABLE marchands');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE medias_images');
        $this->addSql('DROP TABLE medias_videos');
        $this->addSql('DROP TABLE news_letter');
        $this->addSql('DROP TABLE others');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE products_valeurs');
        $this->addSql('DROP TABLE products_liees');
        $this->addSql('DROP TABLE products_liees_products');
        $this->addSql('DROP TABLE products_list');
        $this->addSql('DROP TABLE promotions');
        $this->addSql('DROP TABLE sliders');
        $this->addSql('DROP TABLE sous_categories');
        $this->addSql('DROP TABLE stores');
        $this->addSql('DROP TABLE telephones_store');
        $this->addSql('DROP TABLE telephones_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE valeurs');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240312145030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(1000) NOT NULL, cookies VARCHAR(1000) DEFAULT NULL, event VARCHAR(1000) DEFAULT NULL, date VARCHAR(255) DEFAULT NULL, barcode1 VARCHAR(1000) DEFAULT NULL, barcode2 VARCHAR(1000) DEFAULT NULL, price VARCHAR(1000) DEFAULT NULL, barcode3 VARCHAR(1000) DEFAULT NULL, barcode4 VARCHAR(1000) DEFAULT NULL, seats VARCHAR(255) DEFAULT NULL, price2 VARCHAR(255) DEFAULT NULL, seats2 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE account');
    }
}

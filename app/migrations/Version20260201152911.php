<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260201152911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, adress_number VARCHAR(5) NOT NULL, street VARCHAR(50) NOT NULL, postal VARCHAR(5) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_EF192552A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, adresses_id INT DEFAULT NULL, INDEX IDX_42C8495585E14726 (adresses_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE vehicules (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prix_jour NUMERIC(10, 0) NOT NULL, disponible TINYINT NOT NULL, images VARCHAR(255) NOT NULL, marque VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, categories_id INT DEFAULT NULL, reservation_id INT DEFAULT NULL, INDEX IDX_78218C2DA21214B7 (categories_id), INDEX IDX_78218C2DB83297E7 (reservation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF192552A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495585E14726 FOREIGN KEY (adresses_id) REFERENCES adresses (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2DA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF192552A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495585E14726');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2DA21214B7');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2DB83297E7');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vehicules');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

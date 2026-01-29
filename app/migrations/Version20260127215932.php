<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260127215932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, adresses_number VARCHAR(5) NOT NULL, street VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, postal VARCHAR(5) NOT NULL, country VARCHAR(50) NOT NULL, adresses_complement VARCHAR(50) DEFAULT NULL, users_id INT DEFAULT NULL, INDEX IDX_EF19255267B3B43D (users_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF19255267B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation ADD adresses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495585E14726 FOREIGN KEY (adresses_id) REFERENCES adresses (id)');
        $this->addSql('CREATE INDEX IDX_42C8495585E14726 ON reservation (adresses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF19255267B3B43D');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495585E14726');
        $this->addSql('DROP INDEX IDX_42C8495585E14726 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP adresses_id');
    }
}

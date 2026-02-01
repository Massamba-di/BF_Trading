<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260201214857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('CREATE INDEX IDX_42C849554A4A3511 ON reservation (vehicule_id)');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY `FK_78218C2DB83297E7`');
        $this->addSql('DROP INDEX IDX_78218C2DB83297E7 ON vehicules');
        $this->addSql('ALTER TABLE vehicules DROP reservation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554A4A3511');
        $this->addSql('DROP INDEX IDX_42C849554A4A3511 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP vehicule_id');
        $this->addSql('ALTER TABLE vehicules ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT `FK_78218C2DB83297E7` FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_78218C2DB83297E7 ON vehicules (reservation_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251230224552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD vehicules_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558D8BD7E2 FOREIGN KEY (vehicules_id) REFERENCES vehicules (id)');
        $this->addSql('CREATE INDEX IDX_42C849558D8BD7E2 ON reservation (vehicules_id)');
        $this->addSql('ALTER TABLE vehicules ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_78218C2D67B3B43D ON vehicules (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558D8BD7E2');
        $this->addSql('DROP INDEX IDX_42C849558D8BD7E2 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP vehicules_id');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D67B3B43D');
        $this->addSql('DROP INDEX IDX_78218C2D67B3B43D ON vehicules');
        $this->addSql('ALTER TABLE vehicules DROP users_id');
    }
}

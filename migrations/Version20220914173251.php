<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220914173251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE134659D3ED38D');
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465B72E652A');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE134659D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465B72E652A FOREIGN KEY (droits_id) REFERENCES droits (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE134659D3ED38D');
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465B72E652A');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE134659D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id)');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465B72E652A FOREIGN KEY (droits_id) REFERENCES droits (id)');
    }
}

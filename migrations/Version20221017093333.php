<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221017093333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465523CAB89');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465523CAB89');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id)');
    }
}

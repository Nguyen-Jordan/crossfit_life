<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207153202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9523CAB89');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E92534008B');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E92534008B FOREIGN KEY (structure_id) REFERENCES structures (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9523CAB89');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E92534008B');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E92534008B FOREIGN KEY (structure_id) REFERENCES structures (id)');
    }
}

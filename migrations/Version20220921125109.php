<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921125109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD franchise_id_id INT DEFAULT NULL, ADD structure_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EA39FCC8 FOREIGN KEY (franchise_id_id) REFERENCES franchises (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AA95C5C1 FOREIGN KEY (structure_id_id) REFERENCES structures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9EA39FCC8 ON users (franchise_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AA95C5C1 ON users (structure_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9EA39FCC8');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AA95C5C1');
        $this->addSql('DROP INDEX UNIQ_1483A5E9EA39FCC8 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9AA95C5C1 ON users');
        $this->addSql('ALTER TABLE users DROP franchise_id_id, DROP structure_id_id');
    }
}

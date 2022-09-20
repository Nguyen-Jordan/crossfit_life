<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920091210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9E4D8C609');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9EA39FCC8');
        $this->addSql('DROP INDEX UNIQ_1483A5E9EA39FCC8 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9E4D8C609 ON users');
        $this->addSql('ALTER TABLE users DROP franchise_id, DROP structures_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD franchise_id INT DEFAULT NULL, ADD structures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9E4D8C609 FOREIGN KEY (structures_id) REFERENCES structures (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EA39FCC8 FOREIGN KEY (franchise_id) REFERENCES franchises (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9EA39FCC8 ON users (franchise_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E4D8C609 ON users (structures_id)');
    }
}

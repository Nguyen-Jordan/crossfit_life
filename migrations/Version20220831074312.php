<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831074312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE droits (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franchises (id INT AUTO_INCREMENT NOT NULL, partner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C0D3F0139393F8FE (partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, franchise_id INT NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5BBEC55A783E3463 (manager_id), INDEX IDX_5BBEC55A523CAB89 (franchise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures_droits (structures_id INT NOT NULL, droits_id INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_8BE134659D3ED38D (structures_id), INDEX IDX_8BE13465B72E652A (droits_id), PRIMARY KEY(structures_id, droits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE franchises ADD CONSTRAINT FK_C0D3F0139393F8FE FOREIGN KEY (partner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE structures ADD CONSTRAINT FK_5BBEC55A783E3463 FOREIGN KEY (manager_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE structures ADD CONSTRAINT FK_5BBEC55A523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id)');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE134659D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id)');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465B72E652A FOREIGN KEY (droits_id) REFERENCES droits (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchises DROP FOREIGN KEY FK_C0D3F0139393F8FE');
        $this->addSql('ALTER TABLE structures DROP FOREIGN KEY FK_5BBEC55A783E3463');
        $this->addSql('ALTER TABLE structures DROP FOREIGN KEY FK_5BBEC55A523CAB89');
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE134659D3ED38D');
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465B72E652A');
        $this->addSql('DROP TABLE droits');
        $this->addSql('DROP TABLE franchises');
        $this->addSql('DROP TABLE structures');
        $this->addSql('DROP TABLE structures_droits');
    }
}

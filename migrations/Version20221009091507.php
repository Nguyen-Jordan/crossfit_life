<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009091507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franchises_droits DROP FOREIGN KEY FK_526478869D1D346');
        $this->addSql('ALTER TABLE franchises_droits DROP FOREIGN KEY FK_5264788EA39FCC8');
        $this->addSql('DROP TABLE franchises_droits');
        $this->addSql('ALTER TABLE structures_droits ADD id INT AUTO_INCREMENT NOT NULL, ADD franchise_id INT DEFAULT NULL, CHANGE structures_id structures_id INT DEFAULT NULL, CHANGE droits_id droits_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE structures_droits ADD CONSTRAINT FK_8BE13465523CAB89 FOREIGN KEY (franchise_id) REFERENCES franchises (id)');
        $this->addSql('CREATE INDEX IDX_8BE13465523CAB89 ON structures_droits (franchise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE franchises_droits (id INT AUTO_INCREMENT NOT NULL, franchise_id_id INT NOT NULL, droit_id_id INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_526478869D1D346 (droit_id_id), INDEX IDX_5264788EA39FCC8 (franchise_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE franchises_droits ADD CONSTRAINT FK_526478869D1D346 FOREIGN KEY (droit_id_id) REFERENCES droits (id)');
        $this->addSql('ALTER TABLE franchises_droits ADD CONSTRAINT FK_5264788EA39FCC8 FOREIGN KEY (franchise_id_id) REFERENCES franchises (id)');
        $this->addSql('ALTER TABLE structures_droits MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE structures_droits DROP FOREIGN KEY FK_8BE13465523CAB89');
        $this->addSql('DROP INDEX IDX_8BE13465523CAB89 ON structures_droits');
        $this->addSql('DROP INDEX `primary` ON structures_droits');
        $this->addSql('ALTER TABLE structures_droits DROP id, DROP franchise_id, CHANGE structures_id structures_id INT NOT NULL, CHANGE droits_id droits_id INT NOT NULL');
    }
}

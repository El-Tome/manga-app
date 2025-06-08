<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608181356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE scan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, chapter INT DEFAULT NULL, language VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scan_read (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_scan_id INT NOT NULL, last_chapter_read INT NOT NULL, INDEX IDX_6D2CA3FC79F37AE5 (id_user_id), INDEX IDX_6D2CA3FCF6BA03A3 (id_scan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scan_read ADD CONSTRAINT FK_6D2CA3FC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scan_read ADD CONSTRAINT FK_6D2CA3FCF6BA03A3 FOREIGN KEY (id_scan_id) REFERENCES scan (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE scan_read DROP FOREIGN KEY FK_6D2CA3FC79F37AE5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE scan_read DROP FOREIGN KEY FK_6D2CA3FCF6BA03A3
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scan
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scan_read
        SQL);
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607191846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, avatar_url VARCHAR(2083) DEFAULT NULL, bio VARCHAR(255) DEFAULT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_B1087D9EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9EA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_info
        SQL);
    }
}

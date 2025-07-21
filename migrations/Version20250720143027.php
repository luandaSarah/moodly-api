<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720143027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE moodboard_comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, moodboard_id INT NOT NULL, INDEX IDX_4FC655B1A76ED395 (user_id), INDEX IDX_4FC655B1ADA9CECE (moodboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_comment ADD CONSTRAINT FK_4FC655B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_comment ADD CONSTRAINT FK_4FC655B1ADA9CECE FOREIGN KEY (moodboard_id) REFERENCES moodboard (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_comment DROP FOREIGN KEY FK_4FC655B1A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_comment DROP FOREIGN KEY FK_4FC655B1ADA9CECE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE moodboard_comment
        SQL);
    }
}

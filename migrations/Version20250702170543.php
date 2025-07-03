<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702170543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE moodboard (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, background_color VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT 'draft' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_32016D50A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE moodboard_image (id INT AUTO_INCREMENT NOT NULL, image_url VARCHAR(2083) NOT NULL, moodboard_id INT NOT NULL, INDEX IDX_BD7A0553ADA9CECE (moodboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard ADD CONSTRAINT FK_32016D50A76ED395 FOREIGN KEY (user_id) REFERENCES user_info (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_image ADD CONSTRAINT FK_BD7A0553ADA9CECE FOREIGN KEY (moodboard_id) REFERENCES moodboard (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship CHANGE created_at created_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info DROP avatar_url
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard DROP FOREIGN KEY FK_32016D50A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_image DROP FOREIGN KEY FK_BD7A0553ADA9CECE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE moodboard
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE moodboard_image
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info ADD avatar_url VARCHAR(2083) DEFAULT NULL
        SQL);
    }
}

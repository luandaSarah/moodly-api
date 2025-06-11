<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611141718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_info (avatar_url VARCHAR(2083) DEFAULT NULL, bio VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9EBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD discr VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9EBF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_info
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP discr
        SQL);
    }
}

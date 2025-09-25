<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619114433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE relationship (id INT AUTO_INCREMENT NOT NULL, following_id INT NOT NULL, followed_id INT NOT NULL, INDEX IDX_200444A01816E3A3 (following_id), INDEX IDX_200444A0D956F010 (followed_id), UNIQUE INDEX unique_follow (following_id, followed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A01816E3A3 FOREIGN KEY (following_id) REFERENCES user_info (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A0D956F010 FOREIGN KEY (followed_id) REFERENCES user_info (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship DROP FOREIGN KEY FK_200444A01816E3A3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship DROP FOREIGN KEY FK_200444A0D956F010
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE relationship
        SQL);
    }
}

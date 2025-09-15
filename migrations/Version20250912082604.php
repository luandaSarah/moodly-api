<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912082604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship DROP FOREIGN KEY FK_200444A01816E3A3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship DROP FOREIGN KEY FK_200444A0D956F010
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A01816E3A3 FOREIGN KEY (following_id) REFERENCES user_info (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A0D956F010 FOREIGN KEY (followed_id) REFERENCES user_info (id) ON DELETE CASCADE
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
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A01816E3A3 FOREIGN KEY (following_id) REFERENCES user_info (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE relationship ADD CONSTRAINT FK_200444A0D956F010 FOREIGN KEY (followed_id) REFERENCES user_info (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}

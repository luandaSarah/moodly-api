<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912082048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE moodboard_like (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, moodboard_id INT NOT NULL, INDEX IDX_ECABEEFBA76ED395 (user_id), INDEX IDX_ECABEEFBADA9CECE (moodboard_id), UNIQUE INDEX user_moodboard_unique (user_id, moodboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like ADD CONSTRAINT FK_ECABEEFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like ADD CONSTRAINT FK_ECABEEFBADA9CECE FOREIGN KEY (moodboard_id) REFERENCES moodboard (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like DROP FOREIGN KEY FK_ECABEEFBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like DROP FOREIGN KEY FK_ECABEEFBADA9CECE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE moodboard_like
        SQL);
    }
}

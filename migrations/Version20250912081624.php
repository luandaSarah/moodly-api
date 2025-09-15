<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250912081624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like DROP FOREIGN KEY FK_ECABEEFBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like DROP FOREIGN KEY FK_ECABEEFBADA9CECE
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
            ALTER TABLE moodboard_like ADD CONSTRAINT FK_ECABEEFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE moodboard_like ADD CONSTRAINT FK_ECABEEFBADA9CECE FOREIGN KEY (moodboard_id) REFERENCES moodboard (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
    }
}

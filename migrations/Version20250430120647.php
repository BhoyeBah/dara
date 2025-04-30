<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430120647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE membres_specialites DROP FOREIGN KEY FK_295C33505AEDDAD9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membres_specialites DROP FOREIGN KEY FK_295C335071128C5C
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE membres_specialites
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE specialites CHANGE description description LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE membres_specialites (membres_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_295C335071128C5C (membres_id), INDEX IDX_295C33505AEDDAD9 (specialites_id), PRIMARY KEY(membres_id, specialites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membres_specialites ADD CONSTRAINT FK_295C33505AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE membres_specialites ADD CONSTRAINT FK_295C335071128C5C FOREIGN KEY (membres_id) REFERENCES membres (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE specialites CHANGE description description VARCHAR(255) NOT NULL
        SQL);
    }
}

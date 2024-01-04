<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218093853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE outil_tag (outil_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_85DB84AC3ED89C80 (outil_id), INDEX IDX_85DB84ACBAD26311 (tag_id), PRIMARY KEY(outil_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE outil_tag ADD CONSTRAINT FK_85DB84AC3ED89C80 FOREIGN KEY (outil_id) REFERENCES outil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE outil_tag ADD CONSTRAINT FK_85DB84ACBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outil_tag DROP FOREIGN KEY FK_85DB84AC3ED89C80');
        $this->addSql('ALTER TABLE outil_tag DROP FOREIGN KEY FK_85DB84ACBAD26311');
        $this->addSql('DROP TABLE outil_tag');
    }
}

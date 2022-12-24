<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221224144703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, short VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reply CHANGE value answer_id INT NOT NULL');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0AA334807 FOREIGN KEY (answer_id) REFERENCES question (id)');
        $this->addSql('CREATE INDEX IDX_FDA8C6E0AA334807 ON reply (answer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E0AA334807');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP INDEX IDX_FDA8C6E0AA334807 ON reply');
        $this->addSql('ALTER TABLE reply CHANGE answer_id value INT NOT NULL');
    }
}

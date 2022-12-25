<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221225111412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E0D0E3F35F');
        $this->addSql('DROP INDEX IDX_FDA8C6E0D0E3F35F ON reply');
        $this->addSql('ALTER TABLE reply CHANGE inspector_id instructor_id INT NOT NULL');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E08C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDA8C6E05F37A13B ON reply (token)');
        $this->addSql('CREATE INDEX IDX_FDA8C6E08C4FC193 ON reply (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E08C4FC193');
        $this->addSql('DROP INDEX UNIQ_FDA8C6E05F37A13B ON reply');
        $this->addSql('DROP INDEX IDX_FDA8C6E08C4FC193 ON reply');
        $this->addSql('ALTER TABLE reply CHANGE instructor_id inspector_id INT NOT NULL');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0D0E3F35F FOREIGN KEY (inspector_id) REFERENCES instructor (id)');
        $this->addSql('CREATE INDEX IDX_FDA8C6E0D0E3F35F ON reply (inspector_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221224181942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498C4FC193 ON user (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498C4FC193');
        $this->addSql('DROP INDEX UNIQ_8D93D6498C4FC193 ON user');
        $this->addSql('ALTER TABLE user DROP instructor_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309164724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_race (state_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_4E8C32695D83CC1 (state_id), INDEX IDX_4E8C32696E59D40D (race_id), PRIMARY KEY(state_id, race_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE state_race ADD CONSTRAINT FK_4E8C32695D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state_race ADD CONSTRAINT FK_4E8C32696E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instructor CHANGE state state_id INT NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD CONSTRAINT FK_31FC43DD5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_31FC43DD5D83CC1 ON instructor (state_id)');
        $this->addSql('ALTER TABLE race ADD instructor_id INT DEFAULT NULL, DROP states');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF8C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAF8C4FC193 ON race (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructor DROP FOREIGN KEY FK_31FC43DD5D83CC1');
        $this->addSql('ALTER TABLE state_race DROP FOREIGN KEY FK_4E8C32695D83CC1');
        $this->addSql('ALTER TABLE state_race DROP FOREIGN KEY FK_4E8C32696E59D40D');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE state_race');
        $this->addSql('DROP INDEX IDX_31FC43DD5D83CC1 ON instructor');
        $this->addSql('ALTER TABLE instructor CHANGE state_id state INT NOT NULL');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF8C4FC193');
        $this->addSql('DROP INDEX IDX_DA6FBBAF8C4FC193 ON race');
        $this->addSql('ALTER TABLE race ADD states LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', DROP instructor_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314152017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instructor (id INT AUTO_INCREMENT NOT NULL, state_id INT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(15) DEFAULT NULL, club VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_31FC43DD5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, short VARCHAR(50) NOT NULL, is_active TINYINT(1) NOT NULL, color VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_B6F7494E8F2890A2 (short), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, instructor_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, date DATE NOT NULL, deposit_date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', email_sent TINYINT(1) NOT NULL, INDEX IDX_DA6FBBAF8C4FC193 (instructor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply (id INT AUTO_INCREMENT NOT NULL, instructor_id INT NOT NULL, race_id INT NOT NULL, answer_id INT DEFAULT NULL, token VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_FDA8C6E05F37A13B (token), INDEX IDX_FDA8C6E08C4FC193 (instructor_id), INDEX IDX_FDA8C6E06E59D40D (race_id), INDEX IDX_FDA8C6E0AA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_race (state_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_4E8C32695D83CC1 (state_id), INDEX IDX_4E8C32696E59D40D (race_id), PRIMARY KEY(state_id, race_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, instructor_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6498C4FC193 (instructor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instructor ADD CONSTRAINT FK_31FC43DD5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF8C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E08C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E06E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0AA334807 FOREIGN KEY (answer_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE state_race ADD CONSTRAINT FK_4E8C32695D83CC1 FOREIGN KEY (state_id) REFERENCES state (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state_race ADD CONSTRAINT FK_4E8C32696E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructor DROP FOREIGN KEY FK_31FC43DD5D83CC1');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF8C4FC193');
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E08C4FC193');
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E06E59D40D');
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E0AA334807');
        $this->addSql('ALTER TABLE state_race DROP FOREIGN KEY FK_4E8C32695D83CC1');
        $this->addSql('ALTER TABLE state_race DROP FOREIGN KEY FK_4E8C32696E59D40D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498C4FC193');
        $this->addSql('DROP TABLE instructor');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE reply');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE state_race');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

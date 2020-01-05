<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200101180622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial table creation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, sponsor_type VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venue (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, maps_url VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, venue_id INT DEFAULT NULL, pub_id INT DEFAULT NULL, meetup_id VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_3BAE0AA740A73EBA (venue_id), INDEX IDX_3BAE0AA783FDE077 (pub_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_person (event_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_645A62471F7E88B (event_id), INDEX IDX_645A624217BBB47 (person_id), PRIMARY KEY(event_id, person_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_sponsor (event_id INT NOT NULL, sponsor_id INT NOT NULL, INDEX IDX_4DB607B71F7E88B (event_id), INDEX IDX_4DB607B12F7FB51 (sponsor_id), PRIMARY KEY(event_id, sponsor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talk (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, title VARCHAR(255) NOT NULL, abstract LONGTEXT DEFAULT NULL, original_relative_url VARCHAR(255) DEFAULT NULL, slides_url VARCHAR(255) DEFAULT NULL, joindin_url VARCHAR(255) DEFAULT NULL, video_url VARCHAR(255) DEFAULT NULL, showcase TINYINT(1) NOT NULL, INDEX IDX_9F24D5BB71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talk_person (talk_id INT NOT NULL, person_id INT NOT NULL, INDEX IDX_7C0CD8056F0601D5 (talk_id), INDEX IDX_7C0CD805217BBB47 (person_id), PRIMARY KEY(talk_id, person_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, photo_url VARCHAR(255) DEFAULT NULL, description VARCHAR(4096) DEFAULT NULL, twitter_handle VARCHAR(255) DEFAULT NULL, github_handle VARCHAR(255) DEFAULT NULL, website_url VARCHAR(255) DEFAULT NULL, meetup_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA740A73EBA FOREIGN KEY (venue_id) REFERENCES venue (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA783FDE077 FOREIGN KEY (pub_id) REFERENCES venue (id)');
        $this->addSql('ALTER TABLE event_person ADD CONSTRAINT FK_645A62471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_person ADD CONSTRAINT FK_645A624217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_sponsor ADD CONSTRAINT FK_4DB607B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_sponsor ADD CONSTRAINT FK_4DB607B12F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE talk_person ADD CONSTRAINT FK_7C0CD8056F0601D5 FOREIGN KEY (talk_id) REFERENCES talk (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE talk_person ADD CONSTRAINT FK_7C0CD805217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_sponsor DROP FOREIGN KEY FK_4DB607B12F7FB51');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA740A73EBA');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA783FDE077');
        $this->addSql('ALTER TABLE event_person DROP FOREIGN KEY FK_645A62471F7E88B');
        $this->addSql('ALTER TABLE event_sponsor DROP FOREIGN KEY FK_4DB607B71F7E88B');
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BB71F7E88B');
        $this->addSql('ALTER TABLE talk_person DROP FOREIGN KEY FK_7C0CD8056F0601D5');
        $this->addSql('ALTER TABLE event_person DROP FOREIGN KEY FK_645A624217BBB47');
        $this->addSql('ALTER TABLE talk_person DROP FOREIGN KEY FK_7C0CD805217BBB47');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE venue');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_person');
        $this->addSql('DROP TABLE event_sponsor');
        $this->addSql('DROP TABLE talk');
        $this->addSql('DROP TABLE talk_person');
        $this->addSql('DROP TABLE person');
    }
}

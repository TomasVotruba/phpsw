<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104210721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add slugs';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sponsor ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event ADD slug VARCHAR(280) NOT NULL');
        $this->addSql('ALTER TABLE person ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE talk ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE venue ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP slug');
        $this->addSql('ALTER TABLE person DROP slug');
        $this->addSql('ALTER TABLE sponsor DROP slug');
        $this->addSql('ALTER TABLE talk DROP slug');
        $this->addSql('ALTER TABLE venue DROP slug');
    }
}

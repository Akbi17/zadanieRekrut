<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313141524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messages_authors (messages_id INT NOT NULL, authors_id INT NOT NULL, INDEX IDX_97A77E8AA5905F5A (messages_id), INDEX IDX_97A77E8A6DE2013A (authors_id), PRIMARY KEY(messages_id, authors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages_authors ADD CONSTRAINT FK_97A77E8AA5905F5A FOREIGN KEY (messages_id) REFERENCES messages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messages_authors ADD CONSTRAINT FK_97A77E8A6DE2013A FOREIGN KEY (authors_id) REFERENCES authors (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages_authors DROP FOREIGN KEY FK_97A77E8AA5905F5A');
        $this->addSql('ALTER TABLE messages_authors DROP FOREIGN KEY FK_97A77E8A6DE2013A');
        $this->addSql('DROP TABLE messages_authors');
    }
}

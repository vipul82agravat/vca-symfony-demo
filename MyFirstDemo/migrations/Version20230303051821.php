<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303051821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_work ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE users_work ADD CONSTRAINT FK_9CC7268EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9CC7268EA76ED395 ON users_work (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_work DROP FOREIGN KEY FK_9CC7268EA76ED395');
        $this->addSql('DROP INDEX IDX_9CC7268EA76ED395 ON users_work');
        $this->addSql('ALTER TABLE users_work DROP user_id');
    }
}

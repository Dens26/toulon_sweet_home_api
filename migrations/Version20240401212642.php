<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240401212642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accommodation ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D385412C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_2D385412C54C8C93 ON accommodation (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D385412C54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_2D385412C54C8C93 ON accommodation');
        $this->addSql('ALTER TABLE accommodation DROP type_id');
    }
}

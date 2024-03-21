<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321212257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout des colonnes Accommodation:description et Picture:file';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD file VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP file');
        $this->addSql('ALTER TABLE accommodation DROP description');
    }
}

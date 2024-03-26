<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240325094716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de fichier grand et petit format';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD file_big VARCHAR(255) NOT NULL, CHANGE file file_small VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD file VARCHAR(255) NOT NULL, DROP file_small, DROP file_big');
    }
}

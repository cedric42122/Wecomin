<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191118193930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ordered RENAME INDEX uniq_f5299398de894f8d TO UNIQ_C3121F99DE894F8D');
        $this->addSql('ALTER TABLE ordered RENAME INDEX idx_f5299398a76ed395 TO IDX_C3121F99A76ED395');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ordered RENAME INDEX idx_c3121f99a76ed395 TO IDX_F5299398A76ED395');
        $this->addSql('ALTER TABLE ordered RENAME INDEX uniq_c3121f99de894f8d TO UNIQ_F5299398DE894F8D');
    }
}

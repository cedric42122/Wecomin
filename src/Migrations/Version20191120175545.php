<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120175545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ordered DROP FOREIGN KEY FK_F5299398DE894F8D');
        $this->addSql('DROP INDEX UNIQ_C3121F99DE894F8D ON ordered');
        $this->addSql('ALTER TABLE ordered ADD service_delivery VARCHAR(255) NOT NULL, ADD customer INT NOT NULL, DROP service_delivery_id, DROP user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ordered ADD user INT NOT NULL, DROP service_delivery, CHANGE customer service_delivery_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordered ADD CONSTRAINT FK_F5299398DE894F8D FOREIGN KEY (service_delivery_id) REFERENCES service_delivery (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C3121F99DE894F8D ON ordered (service_delivery_id)');
    }
}

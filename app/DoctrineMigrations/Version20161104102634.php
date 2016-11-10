<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161104102634 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE request DROP INDEX UNIQ_3B978F9FF5B7AF75, ADD INDEX IDX_3B978F9FF5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE answer CHANGE choice_id choice_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE answer CHANGE choice_id choice_id INT NOT NULL');
        $this->addSql('ALTER TABLE request DROP INDEX IDX_3B978F9FF5B7AF75, ADD UNIQUE INDEX UNIQ_3B978F9FF5B7AF75 (address_id)');
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Generate Intervention Time Range
 */
class Version20161107151448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO intervention_time_range (name, label) VALUES ("morning", "Matin (9h-12h)")');
        $this->addSql('INSERT INTO intervention_time_range (name, label) VALUES ("noon", "Midi (12h-14h)")');
        $this->addSql('INSERT INTO intervention_time_range (name, label) VALUES ("afternoon", "Après-midi (14h-18h)")');
        $this->addSql('INSERT INTO intervention_time_range (name, label) VALUES ("evening", "Début de soirée (18h-20h)")');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DELETE FROM intervention_time_range');
    }
}

<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161101190515 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, `label` VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(45) DEFAULT NULL, street VARCHAR(45) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, postal_code VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, choice_id INT NOT NULL, value LONGTEXT DEFAULT NULL, INDEX IDX_DADD4A25427EB8A5 (request_id), INDEX IDX_DADD4A25998666D1 (choice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choice (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, `label` VARCHAR(45) NOT NULL, INDEX IDX_C1AB5A921E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_time_range (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, `label` VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_attempt (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, lemonway_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, message VARCHAR(255) DEFAULT NULL, INDEX IDX_1A50C8C427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, `label` VARCHAR(45) NOT NULL, INDEX IDX_D34A04AD81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_question (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, question_id INT NOT NULL, position INT NOT NULL, INDEX IDX_7D4723D94584665A (product_id), INDEX IDX_7D4723D91E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, firstname VARCHAR(45) DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, iban VARCHAR(45) DEFAULT NULL, bic VARCHAR(45) DEFAULT NULL, is_working_at_night TINYINT(1) DEFAULT NULL, is_working_on_weekend TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_B3B573AAF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional_activity (professional_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_3FF2D3E7DB77003 (professional_id), INDEX IDX_3FF2D3E781C06096 (activity_id), PRIMARY KEY(professional_id, activity_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, `label` VARCHAR(45) NOT NULL, type VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, product_id INT NOT NULL, address_id INT NOT NULL, created_at DATETIME NOT NULL, accepted_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, price INT DEFAULT NULL, intervention_date DATE DEFAULT NULL, payment_code VARCHAR(6) DEFAULT NULL, INDEX IDX_3B978F9FA76ED395 (user_id), INDEX IDX_3B978F9F4584665A (product_id), UNIQUE INDEX UNIQ_3B978F9FF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_time_range (request_id INT NOT NULL, intervention_time_range_id INT NOT NULL, INDEX IDX_9E0C7C8F427EB8A5 (request_id), INDEX IDX_9E0C7C8F90031FB1 (intervention_time_range_id), PRIMARY KEY(request_id, intervention_time_range_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sent_request (id INT AUTO_INCREMENT NOT NULL, request_id INT NOT NULL, professional_id INT NOT NULL, created_at DATETIME NOT NULL, accepted_at DATETIME DEFAULT NULL, refused_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, INDEX IDX_411EB880427EB8A5 (request_id), INDEX IDX_411EB880DB77003 (professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(45) DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25998666D1 FOREIGN KEY (choice_id) REFERENCES choice (id)');
        $this->addSql('ALTER TABLE choice ADD CONSTRAINT FK_C1AB5A921E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE payment_attempt ADD CONSTRAINT FK_1A50C8C427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE product_question ADD CONSTRAINT FK_7D4723D94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_question ADD CONSTRAINT FK_7D4723D91E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE professional ADD CONSTRAINT FK_B3B573AAF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE professional_activity ADD CONSTRAINT FK_3FF2D3E7DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professional_activity ADD CONSTRAINT FK_3FF2D3E781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE request_time_range ADD CONSTRAINT FK_9E0C7C8F427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE request_time_range ADD CONSTRAINT FK_9E0C7C8F90031FB1 FOREIGN KEY (intervention_time_range_id) REFERENCES intervention_time_range (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sent_request ADD CONSTRAINT FK_411EB880427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('ALTER TABLE sent_request ADD CONSTRAINT FK_411EB880DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD81C06096');
        $this->addSql('ALTER TABLE professional_activity DROP FOREIGN KEY FK_3FF2D3E781C06096');
        $this->addSql('ALTER TABLE professional DROP FOREIGN KEY FK_B3B573AAF5B7AF75');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FF5B7AF75');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25998666D1');
        $this->addSql('ALTER TABLE request_time_range DROP FOREIGN KEY FK_9E0C7C8F90031FB1');
        $this->addSql('ALTER TABLE product_question DROP FOREIGN KEY FK_7D4723D94584665A');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9F4584665A');
        $this->addSql('ALTER TABLE professional_activity DROP FOREIGN KEY FK_3FF2D3E7DB77003');
        $this->addSql('ALTER TABLE sent_request DROP FOREIGN KEY FK_411EB880DB77003');
        $this->addSql('ALTER TABLE choice DROP FOREIGN KEY FK_C1AB5A921E27F6BF');
        $this->addSql('ALTER TABLE product_question DROP FOREIGN KEY FK_7D4723D91E27F6BF');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25427EB8A5');
        $this->addSql('ALTER TABLE payment_attempt DROP FOREIGN KEY FK_1A50C8C427EB8A5');
        $this->addSql('ALTER TABLE request_time_range DROP FOREIGN KEY FK_9E0C7C8F427EB8A5');
        $this->addSql('ALTER TABLE sent_request DROP FOREIGN KEY FK_411EB880427EB8A5');
        $this->addSql('ALTER TABLE request DROP FOREIGN KEY FK_3B978F9FA76ED395');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE choice');
        $this->addSql('DROP TABLE intervention_time_range');
        $this->addSql('DROP TABLE payment_attempt');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_question');
        $this->addSql('DROP TABLE professional');
        $this->addSql('DROP TABLE professional_activity');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE request_time_range');
        $this->addSql('DROP TABLE sent_request');
        $this->addSql('DROP TABLE user');
    }
}
